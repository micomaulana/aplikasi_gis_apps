<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\LaporaKasusDbd;
use App\Models\LaporanFogging;
use App\Models\Pasien;
use App\Models\Statistik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $desas = Desa::paginate(10);
        return view('desa.index', compact('desas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('desa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'longitude' => 'required',
            'latitude' => 'required'
        ]);

        Desa::create($request->all());
        return redirect()->back()->with('success', 'insert data berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Desa $desa)
    {
        return view('desa.show', compact('desa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Desa $desa)
    {
        return view('desa.edit', compact('desa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Desa $desa)
    {
        $desa->update($request->all());
        return redirect()->back()->with('success', 'update data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Desa $desa)
    {
        $desa->delete();
        return redirect()->back()->with('success', 'delete data berhasil');
    }


    public function maps()
    {
        // $desas = Desa::all();
        $desas = DB::table('pasiens')
            ->join('desas', 'pasiens.id_desa', '=', 'desas.id')
            ->select([
                'pasiens.id',
                'pasiens.nama as nama_pasien',
                'pasiens.alamat',
                'pasiens.usia',
                'pasiens.provinsi',
                'pasiens.kab_kota',
                'pasiens.tempat_lahir',
                'pasiens.tanggal_lahir',
                'pasiens.jenis_kelamin',
                'desas.nama as nama_desa',
                'desas.latitude',
                'desas.longitude'
            ])
            ->get();
        // dd($desas);
        return view('desa.maps', compact('desas'));
    }
    public function data_informasi_view()
    {
        $desas = Desa::all();
        $statistiks = Statistik::all();
        return view('data_dan_informasi.index', compact('desas', 'statistiks'));
    }
    public function laporan_view()
    {
        $desas = Desa::all();

        $laporan_foggings = LaporanFogging::all();
        return view('laporan.index', compact('desas', 'laporan_foggings'));
    }

    public function hitung_kasus_dari_id_desa($id)
    {
        $pasiens_count = Pasien::where('id_desa', '=', $id)->count();
        return response()->json([
            'status' => true,
            'message' => "success fetch data",
            'data' => $pasiens_count
        ],);
    }
    public function validasi_pasien_admin_view()
    {
        return view('validasi_pasien_admin.index');
    }
    public function laporan_masyarakat_view()
    {
        $laporan_dbd = LaporaKasusDbd::select(
            'id_pasien',
            DB::raw('GROUP_CONCAT(gejala_yang_dialami) as gejala_yang_dialami'),
            DB::raw('GROUP_CONCAT(gejala_lain) as gejala_lain'),
            DB::raw('GROUP_CONCAT(file_hasil_lab) as file_hasil_lab'),
            DB::raw('GROUP_CONCAT(status) as status')
        )
            ->groupBy('id_pasien')
            ->get();

        // dd($laporan_dbd);
        return view('laporan_masyarakat.index', compact('laporan_dbd'));
    }
    public function tambah_laporan()
    {
        $pasien = Pasien::where('email', '=', Auth::user()->email)->first();
        return view('laporan_masyarakat.create', compact('pasien'));
    }
    public function simpan_laporan_masyarakat(Request $request)
    {
        $validated = $request->validate([
            'gejala_yang_dialami' => 'required',
            'gejala_lain' => 'required',
            'file_hasil_lab' => 'required|file|mimes:pdf,jpg,png|max:2048'
        ]);

        $pasien = Pasien::where('email', '=', Auth::user()->email)->first();

        if ($pasien) {
            // Tangani file hasil lab
            if ($request->hasFile('file_hasil_lab')) {
                $file = $request->file('file_hasil_lab');
                $fileName = time() . '_' . $file->getClientOriginalName(); // Nama unik untuk file
                $destinationPath = public_path('uploads/laporan'); // Path penyimpanan
                $file->move($destinationPath, $fileName); // Pindahkan file

                for ($i = 0; $i < count($validated['gejala_yang_dialami']); $i++) {
                    LaporaKasusDbd::create([
                        'id_pasien' => $pasien->id,
                        'gejala_yang_dialami' => $validated['gejala_yang_dialami'][$i],
                        'gejala_lain' => $validated['gejala_lain'],
                        'file_hasil_lab' => $fileName,
                        'status' => 'waiting'
                    ]);
                }
                return redirect()->route('laporan_masyarakat')->with('success', 'Create data success');
            }

            return redirect()->route('tambah_laporan')->with('fails', 'File upload failed');
        }

        return redirect()->route('tambah_laporan')->with('fails', 'Create data fails');
    }

    public function get_laporan_dbd_by_id_pasien($id){
        $laporan_dbd = LaporaKasusDbd::where('id_pasien','=',$id)->with('pasien')->first();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $laporan_dbd 
        ],200);
    }
}
