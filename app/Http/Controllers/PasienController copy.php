<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_old()
    {
        $pasiens = Pasien::paginate(10);
        return view('pasien.index', compact('pasiens'));
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query_data = Pasien::query();

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data->where(function ($query) use ($search_value) {
                    $query->where('nama', 'like', $search_value)
                        ->orWhere('alamat', 'like', $search_value)
                        ->orWhere('usia', 'like', $search_value)
                        ->orWhere('id_desa', 'like', $search_value)
                        ->orWhere('provinsi', 'like', $search_value)
                        ->orWhere('kab_kota', 'like', $search_value)
                        ->orWhere('tempat_lahir', 'like', $search_value)
                        ->orWhere('tanggal_lahir', 'like', $search_value)
                        ->orWhere('jenis_kelamin', 'like', $search_value)
                        ->orWhere('Diagnosis_lab', 'like', $search_value)
                        ->orWhere('Diagnosis_klinis', 'like', $search_value)
                        ->orWhere('Status_akhir', 'like', $search_value);
                });
            }

            $data = $query_data->orderBy('nama', 'asc')->get();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <form action="' . route('pasiens.destroy', $row->id) . '" method="POST">
                        <a class="btn btn-info" href="' . route('pasiens.show', $row->id) . '">Show</a>
                        <a class="btn btn-primary" href="' . route('pasiens.edit', $row->id) . '">Edit</a>
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>';
                    return $btn;
                })->addColumn('nama_desa', function ($row) {
                    return $row->desa->nama;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pasien.index');
    }







    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_desas = Desa::all();
        return view('pasien.create', compact('data_desas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'usia' => 'required',
            'id_desa' => 'required',
            'provinsi' => 'required',
            'kab_kota' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'Diagnosis_lab' => 'required',
            'Diagnosis_klinis' => 'required',
            'Status_akhir' => 'required',
        ]);
        Pasien::create($request->all());
        return redirect()->back()->with('success', 'insert data berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pasien $pasien)
    {
        return view('pasien.show', compact('pasien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pasien $pasien)
    {
        $pasien->update($request->all());
        return redirect()->back()->with('success', 'update data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->back()->with('success', 'delete data berhasil');
    }

    public function get_data_pasien_by_desa($id)
    {
        try {

            $pasien_by_id_desa = Pasien::where('id_desa', '=', $id)
                ->selectRaw('tahun_terdata, COUNT(*) as jumlah_pasien')
                ->groupBy('tahun_terdata')
                ->get();
            $count_pasien_by_id_desa = Pasien::where('id_desa', '=', $id)
                ->count();
            $jumlah_pasien_2022 = $pasien_by_id_desa->where('tahun_terdata', '2022')->first()->jumlah_pasien ?? 0;
            $jumlah_pasien_2023 = $pasien_by_id_desa->where('tahun_terdata', '2023')->first()->jumlah_pasien ?? 0;
            $jumlah_pasien_2024 = $pasien_by_id_desa->where('tahun_terdata', '2024')->first()->jumlah_pasien ?? 0;

            $data = [
                'jumlah_pasien_2022' => $jumlah_pasien_2022,
                'jumlah_pasien_2023' => $jumlah_pasien_2023,
                'jumlah_pasien_2024' => $jumlah_pasien_2024
            ];

            $data_tahun_chart = [
                $jumlah_pasien_2022,
                $jumlah_pasien_2023,
                $jumlah_pasien_2024
            ];


            $data_chart = [
                'labels' => ['2022', '2023', '2024'],
                'values' => $data_tahun_chart
            ];
            return response()->json([
                'status' => true,
                'message' => "request success",
                'data' => $data,
                'data_chart' => $data_chart,
                'jumlah_pasien' => $count_pasien_by_id_desa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "request failed",
                'data' => $e->getMessage()
            ], 200);
        }
    }
}
