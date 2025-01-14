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

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data->where(function ($query) use ($search_value) {
                    $query->where('nama', 'like', $search_value)
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
                    $btn = '
    <form action="' . route('pasiens.destroy', $row->id) . '" method="POST">
        <a class="btn btn-info" href="' . route('pasiens.show', $row->id) . '">Show</a>';

                    if (Auth::user()->can('pasien-edit')) {
                        $btn .= '<a class="btn btn-primary" href="' . route('pasiens.edit', $row->id) . '">Edit</a>';
                    }

                    if (Auth::user()->can('pasien-delete')) {
                        $btn .= csrf_field() . method_field('DELETE') . '
        <button type="submit" class="btn btn-danger">Delete</button>';
                    }

                    $btn .= '
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
            $query = Pasien::where('id_desa', '=', $id);

            // Add year filter if provided
            if ($request->has('tahun') && $request->tahun) {
                $query->where('tahun_terdata', $request->tahun);
            }

            $query->selectRaw('tahun_terdata, COUNT(*) as jumlah_pasien')
                ->groupBy('tahun_terdata')
                ->get(); // Get the results

            $latestRecord = Pasien::where('id_desa', '=', $id)
                ->orderByDesc('tahun_terdata')
                ->first();

            // Extract the year and month from the latest record
            $latestYear = \Carbon\Carbon::parse($latestRecord->tahun_terdata)->year;
            $latestMonth = \Carbon\Carbon::parse($latestRecord->tahun_terdata)->month;

            // Count the number of patients for the latest year and month
            $count_pasien_by_id_desa = Pasien::where('id_desa', '=', $id)
                ->whereYear('tahun_terdata', '=', $latestYear)
                ->whereMonth('tahun_terdata', '=', $latestMonth)
                ->count();
            $desa = Desa::where('id','=',$id)->first();
            // Parse the year from the request
            // $year = \Carbon\Carbon::parse($request->tahun)->year;
            $year = $request->tahun;

            $data_tahun_chart = [];
            $labels = [];

            // Loop through the current year and the next two years (2022, 2023, 2024)
            for ($i = 0; $i < 3; $i++) {
                $current_year = $year + $i;  // Get the current year in the loop (2022, 2023, 2024)

                // Query the count of patients for the current year
                $jumlah_pasien_by_year = Pasien::where('id_desa', '=', $id)
                    ->whereYear('tahun_terdata', '=', $current_year)
                    ->count();

                // Store the result in the data array
                $data_tahun_chart[] = $jumlah_pasien_by_year;
                $labels[] = (string)$current_year;  // Add the current year to the labels array
            }

            // Prepare data for the response
            $data = [
                'jumlah_pasien_by_filter' => $data_tahun_chart,  // Include the patient counts for each year
            ];

            // Returning the response with the data and chart data
            // return response()->json([
            //     'status' => true,
            //     'message' => "Request success",
            //     'data' => $data,
            //     'data_chart' => [
            //         'labels' => $labels,  // ['2022', '2023', '2024']
            //         'values' => $data_tahun_chart,  // [count for 2022, count for 2023, count for 2024]
            //     ]
            // ], 200);

            $data_chart = [
                'labels' => $labels,
                'values' => $data_tahun_chart
            ];

            return response()->json([
                'status' => true,
                'message' => "request success",
                'data' => $data,
                'tahun' =>  $year,
                'data_chart' => $data_chart,
                'desa' => $desa,
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
