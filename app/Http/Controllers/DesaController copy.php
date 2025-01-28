<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Dokter;
use App\Models\LaporaKasusDbd;
use App\Models\LaporanFogging;
use App\Models\Pasien;
use App\Models\Statistik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DesaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:desa-list|desa-create|desa-edit|desa-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:desa-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:desa-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:desa-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Query data desa
            $query_data = Desa::query();

            // Filter pencarian
            if ($request->has('sSearch') && $request->sSearch !== null) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data->where(function ($query) use ($search_value) {
                    $query->where('nama', 'like', $search_value)
                        ->orWhere('latitude', 'like', $search_value)
                        ->orWhere('longitude', 'like', $search_value);
                });
            }

            // Urutkan dan ambil data
            $data = $query_data->orderBy('id', 'asc')->get();

            // Konfigurasi DataTables
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
    <form action="' . route('desas.destroy', $row->id) . '" method="POST">
        <a class="btn btn-info btn-sm" href="' . route('desas.show', $row->id) . '">Show</a>';

                    if (Auth::user()->can('desa-edit')) {
                        $btn .= '<a class="btn btn-primary btn-sm" href="' . route('desas.edit', $row->id) . '">Edit</a>';
                    }

                    if (Auth::user()->can('desa-delete')) {
                        $btn .= csrf_field() . method_field('DELETE') . '
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>';
                    }

                    $btn .= '
    </form>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Tampilkan halaman utama
        return view('desa.index');
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
        return redirect()->route('desas.index')->with('success', 'insert data berhasil');
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
        return redirect()->route('desas.index')->with('success', 'update data berhasil');
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
        $desas = DB::table('desas')
            ->get();
        $desa_loc = DB::table('desas')->select('longitude', 'latitude')->latest()->first();
        return view('desa.maps', compact('desas', 'desa_loc'));
    }
    public function getPasien($iddesa)
    {
        try {
            $pasien = Pasien::where('id_desa', '=', $iddesa)
                ->where('diagnosis_klinis', '=', 'DBD') // Filter berdasarkan diagnosis klinis
                ->with('desa')
                ->get();
            $count = $pasien->count();

            return response()->json([
                'status' => $count > 0, // Status true hanya jika ada data
                'data' => $pasien,
                'count' => $count
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
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
        $pasiens_count = Pasien::where('id_desa', '=', $id)
            ->whereYear('tahun_terdata', '=', date('Y')) // Tambahkan filter tahun
            ->count();
        return response()->json([
            'status' => true,
            'message' => "success fetch data",
            'data' => $pasiens_count
        ],);
    }
    public function validasi_pasien_admin_view()
    {
        $dokters = Dokter::all();
        $jumlah_laporan = DB::table('laporan_kasus_dbd')
            ->distinct('id_pasien')
            ->count('id_pasien');
        $jumlah_laporan_menunggu_validasi = DB::table('laporan_kasus_dbd')
            ->distinct('id_pasien')
            ->where('status', 'waiting')
            ->count('id_pasien');
        $jumlah_laporan_terkonfirmasi = DB::table('laporan_kasus_dbd')
            ->distinct('id_pasien')
            ->where('status', '!=', 'waiting')
            ->where('status', '!=', 'rejected')  // Menambahkan kondisi status = 'waiting'
            ->count('id_pasien');
        $jumlah_laporan_rejected = DB::table('laporan_kasus_dbd')
            ->distinct('id_pasien')
            ->where('status', '=', 'rejected')
            ->count('id_pasien');



        // Mendapatkan laporan kasus DBD dan mengelompokkan berdasarkan id_pasien
        $laporandbd = LaporaKasusDbd::with('pasien')
            ->orderBy('created_at', 'desc') // Ganti 'created_at' dengan kolom yang sesuai
            ->get()
            ->groupBy('id_pasien');

        // Memetakan data ke format yang lebih terstruktur
        $groupedData = $laporandbd->map(function ($laporans) {
            // Urutkan laporan berdasarkan tanggal secara descending
            $sortedLaporans = $laporans->sortByDesc('created_at');

            return $sortedLaporans->map(function ($laporan) {
                return [
                    'no_tiket' => $laporan->no_tiket,
                    'tanggal' => $laporan->created_at->format('d M Y'),
                    'status' => ucfirst($laporan->status),
                    'pasien' => $laporan->pasien, // Menyertakan data pasien
                    'gejala' => $laporan->gejala_yang_dialami,
                    'gejala_lain' => $laporan->gejala_lain,
                    'file_hasil_lab' => $laporan->file_hasil_lab,
                    'created_at' => $laporan->created_at
                ];
            });
        });


        // dd($groupedData);
        return view('validasi_pasien_admin.index', compact('dokters', 'groupedData', 'jumlah_laporan', 'jumlah_laporan_menunggu_validasi', 'jumlah_laporan_terkonfirmasi', 'jumlah_laporan_rejected'));
    }



    public function laporan_masyarakat_view()
    {
        $pasien = Pasien::where('email', '=', Auth::user()->email)->first();

        $laporan_dbd = LaporaKasusDbd::select(
            'id_pasien',
            DB::raw('GROUP_CONCAT(gejala_yang_dialami) as gejala_yang_dialami'),
            DB::raw('GROUP_CONCAT(gejala_lain) as gejala_lain'),
            DB::raw('GROUP_CONCAT(file_hasil_lab) as file_hasil_lab'),
            DB::raw('GROUP_CONCAT(status) as status')
        )->where('id_pasien', '=', $pasien->id)
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
        $tahunSekarang = Carbon::now()->year;

        if ($pasien) {
            // Tangani file hasil lab
            if ($request->hasFile('file_hasil_lab')) {
                $file = $request->file('file_hasil_lab');
                $fileName = time() . '_' . $file->getClientOriginalName(); // Nama unik untuk file
                $destinationPath = public_path('uploads/laporan'); // Path penyimpanan
                $file->move($destinationPath, $fileName); // Pindahkan file

                $nomorTerakhir = DB::table('laporan_kasus_dbd')
                    ->where('no_tiket', 'like', "DBD-$tahunSekarang-%")
                    ->orderBy('no_tiket', 'desc')
                    ->value('no_tiket');

                if ($nomorTerakhir) {
                    $angkaTerakhir = (int) substr($nomorTerakhir, strrpos($nomorTerakhir, '-') + 1);
                    $angkaBaru = $angkaTerakhir + 1;
                } else {
                    $angkaBaru = 1;
                }
                $nomorUrutBaru = sprintf("DBD-%s-%03d", $tahunSekarang, $angkaBaru);

                for ($i = 0; $i < count($validated['gejala_yang_dialami']); $i++) {
                    LaporaKasusDbd::create([
                        'id_pasien' => $pasien->id,
                        'gejala_yang_dialami' => $validated['gejala_yang_dialami'][$i],
                        'gejala_lain' => $validated['gejala_lain'],
                        'file_hasil_lab' => $fileName,
                        'status' => 'waiting',
                        'no_tiket' => $nomorUrutBaru
                    ]);
                }
                return redirect()->route('laporan_masyarakat')->with('success', 'Create data success');
            }

            return redirect()->route('tambah_laporan')->with('fails', 'File upload failed');
        }

        return redirect()->route('tambah_laporan')->with('fails', 'Create data fails');
    }

    public function get_laporan_dbd_by_id_pasien($id)
    {
        $laporan_dbd = LaporaKasusDbd::where('id_pasien', '=', $id)->with('pasien')->with('dokter')->first();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $laporan_dbd
        ], 200);
    }
    public function tolakLaporan(Request $request, $id)
    {
        // Find the report by ID
        $laporan_dbd = LaporaKasusDbd::where("id_pasien", '=', $id)->get();


        foreach ($laporan_dbd as $key => $laporan) {
            $laporan->update([
                'status' => "rejected"
            ]);
        }

        // Update the status to 'rejected'
        // $laporan_dbd->status = 'rejected';
        // $laporan_dbd->save();

        return response()->json(['message' => 'Laporan berhasil ditolak.']);
    }
    public function validasi_kapus()
    {
        $dokters = Dokter::all();
        $jumlah_laporan = DB::table('laporan_foggings')
            ->count('id_desa');
        $jumlah_laporan_menunggu_validasi = DB::table('laporan_foggings')
            ->distinct('id_desa')
            ->where('status_pengajuan', 'waiting')
            ->count('id_desa');
        $jumlah_laporan_terkonfirmasi = DB::table('laporan_foggings')
            ->where('status_pengajuan', '!=', 'waiting')
            ->where('status_pengajuan', '!=', 'rejected')  // Menambahkan kondisi status = 'waiting'
            ->count('id_desa');
        $jumlah_laporan_rejected = DB::table('laporan_foggings')
            ->distinct('id_desa')
            ->where('status_pengajuan', '=', 'rejected')
            ->count('id_desa');



        // Mendapatkan laporan kasus DBD dan mengelompokkan berdasarkan id_pasien
        $laporanfoggings = LaporanFogging::all();

        $jumlah_kasus = LaporanFogging::select('id_desa', DB::raw('COUNT(*) as jumlah_kasus'))
            ->groupBy('id_desa')
            ->pluck('jumlah_kasus', 'id_desa');

        // Memetakan data ke format yang lebih terstruktur


        // dd($groupedData);
        return view('validasi_kapus.index', compact('dokters', 'laporanfoggings', 'jumlah_laporan', 'jumlah_laporan_menunggu_validasi', 'jumlah_laporan_terkonfirmasi', 'jumlah_laporan_rejected'));
    }
    public function landing_page()
    {
        $data = DB::table('pasiens')
            ->where('diagnosis_klinis', '=', 'DBD')
            ->select(DB::raw("YEAR(tahun_terdata) as year, COUNT(nama) as count"))
            ->groupBy(DB::raw("YEAR(tahun_terdata)"))
            ->orderBy(DB::raw("YEAR(tahun_terdata)"), 'asc')
            ->get();

        // Debug data
        // dd($data);

        $categories = $data->pluck('year')->toArray(); // Tahun (x-axis)
        $series = $data->pluck('count')->toArray();   // Jumlah pasien (y-axis)

        return view('Landing_page.index', compact('categories', 'series'));
    }


    public function dashboard_masyarakat()
    {
        return view('Dashboard_masyarakat.index');
    }
    public function faq_masyarakat()
    {
        return view('faq_masyarakat.index');
    }
    public function getDataChartLanding()
    {
        try {
            // Ambil data pasien berdasarkan tahun terdata
            $data = Pasien::selectRaw('tahun_terdata, COUNT(*) as jumlah')
                ->groupBy('tahun_terdata')
                ->orderBy('tahun_terdata', 'ASC')
                ->get();

            // Format data untuk chart
            $labels = $data->pluck('tahun_terdata')->toArray();
            $values = $data->pluck('jumlah')->toArray();

            return response()->json([
                'data_chart' => [
                    'labels' => $labels,
                    'values' => $values,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
