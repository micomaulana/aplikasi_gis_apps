<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pasien-list|pasien-create|pasien-edit|pasien-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:pasien-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pasien-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pasien-delete', ['only' => ['destroy']]);
    }
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

            // Year filter
            if ($request->has('year') && !empty($request->year)) {
                $query_data->where('diagnosis_klinis', '=', 'DBD')->whereYear('tahun_terdata', $request->year);
            } else {
                // If no year selected, show data from 2022 onwards
                $query_data->where('diagnosis_klinis', '=', 'DBD')->whereYear('tahun_terdata', '>=', 2022);
            }

            // Search functionality
            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data->where(function ($query) use ($search_value) {
                    $query
                        ->where('nama', 'like', $search_value)
                        ->orWhere('NIK', 'like', $search_value)
                        ->orWhere('alamat', 'like', $search_value)
                        ->orWhere('email', 'like', $search_value)
                        ->orWhere('usia', 'like', $search_value)
                        ->orWhere('id_desa', 'like', $search_value)
                        ->orWhere('provinsi', 'like', $search_value)
                        ->orWhere('kab_kota', 'like', $search_value)
                        ->orWhere('tempat_lahir', 'like', $search_value)
                        ->orWhere('tanggal_lahir', 'like', $search_value)
                        ->orWhere('jenis_kelamin', 'like', $search_value)
                        ->orWhere('diagnosis_lab', 'like', $search_value)
                        ->orWhere('diagnosis_klinis', 'like', $search_value)
                        ->orWhere('status_akhir', 'like', $search_value)
                        ->orWhere('no_hp', 'like', $search_value)
                        ->orWhere('tahun_terdata', 'like', $search_value);
                });
            }

            $data = $query_data->orderBy('nama', 'asc')->get();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions = '<div class="btn-group" role="group">';

                    // Show button
                    $actions .= '<a href="' . route('pasiens.show', $row->id) . '" 
                                class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>';

                    // Edit button
                    if (Auth::user()->can('pasien-edit')) {
                        $actions .= '<a href="' . route('pasiens.edit', $row->id) . '" 
                                    class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>';
                    }

                    // Delete button
                    if (Auth::user()->can('pasien-delete')) {
                        $actions .= '<form action="' . route('pasiens.destroy', $row->id) . '" 
                                        method="POST" class="d-inline" 
                                        onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\');">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->addColumn('nama_desa', function ($row) {
                    return $row->desa->nama ?? '-';
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
            'NIK' => 'required',
            'alamat' => 'required',
            'email' => 'nullable|string',
            'usia' => 'required',
            'id_desa' => 'required',
            'provinsi' => 'required',
            'kab_kota' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'diagnosis_lab' => 'required',
            'diagnosis_klinis' => 'required',
            'status_akhir' => 'required',
            'no_hp' => 'nullable|string',
            'tahun_terdata' => 'required',
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
        $data_desas = Desa::all();
        return view('pasien.edit', compact('data_desas', 'pasien'));
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

    public function get_data_pasien_by_desa($id, Request $request)
{
    try {
        $desa = Desa::where('id', '=', $id)->first();
        
        // Ambil tahun dari request
        $selectedYear = (int)$request->tahun;
        
        // Inisialisasi array untuk data per tahun
        $data_tahun_chart = [];
        $labels = [];
        
        // Hitung jumlah pasien untuk tahun yang dipilih dan 2 tahun setelahnya
        for ($i = 0; $i < 3; $i++) {
            $currentYear = $selectedYear + $i;
            
            // Query jumlah pasien untuk tahun tersebut
            $jumlah_pasien = Pasien::where('id_desa', '=', $id)
                ->whereYear('tahun_terdata', '=', $currentYear)
                ->count();
            
            $data_tahun_chart[] = $jumlah_pasien;
            $labels[] = (string)$currentYear;
        }
        
        // Ambil jumlah pasien untuk tahun yang dipilih (untuk status)
        $jumlah_pasien_tahun_ini = Pasien::where('id_desa', '=', $id)
            ->whereYear('tahun_terdata', '=', $selectedYear)
            ->count();
        
        // Siapkan data response
        $data = [
            'jumlah_pasien_by_filter' => $data_tahun_chart,
            'tahun_terpilih' => $selectedYear,
            'jumlah_pasien_tahun_ini' => $jumlah_pasien_tahun_ini
        ];
        
        $data_chart = [
            'labels' => $labels,
            'values' => $data_tahun_chart
        ];

        return response()->json([
            'status' => true,
            'message' => "request success",
            'data' => $data,
            'tahun' => $selectedYear,
            'data_chart' => $data_chart,
            'desa' => $desa,
            'jumlah_pasien' => $jumlah_pasien_tahun_ini // Menggunakan jumlah pasien tahun yang dipilih
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => "request failed",
            'error' => $e->getMessage()
        ], 500); // Mengubah status code menjadi 500 untuk error
    }
}

    public function get_data_pasien_alert()
    {
        $tanggal = Carbon::now()->startOfMonth()->format('Y-m-d');
        $current_month = Carbon::now()->format('F Y');
        $desas = Desa::whereHas('pasien', function ($query) use ($tanggal) {
            $query->where('created_at', '>=', $tanggal);
        })->withCount('pasien')->get();

        return response()->json([
            'status' => true,
            'message' => "request success",
            'data' => $desas,
            'month' => $current_month
        ], 200);
    }

    public function get_pasien_detail($idpasien)
    {
        $pasien = Pasien::where('id', '=', $idpasien)->with('desa')->first();
        return response()->json([
            'status' => 'success',
            'data' => $pasien
        ], 200);
    }
}
