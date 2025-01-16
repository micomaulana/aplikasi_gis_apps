<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:dokter-list|dokter-create|dokter-edit|dokter-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:dokter-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:dokter-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:dokter-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index_old()
    {
        $dokters = dokter::paginate(10);
        return view('dokter.index');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Query data dokter
            $query_data = Dokter::query();

            // Filter pencarian
            if ($request->has('sSearch') && $request->sSearch !== null) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data->where(function ($query) use ($search_value) {
                    $query->where('nama', 'like', $search_value)
                        ->orWhere('nip', 'like', $search_value)
                        ->orWhere('status', 'like', $search_value)
                        ->orWhere('email', 'like', $search_value)
                        ->orWhere('alamat', 'like', $search_value)
                        ->orWhere('no_hp', 'like', $search_value)
                        ->orWhere('jenis_kelamin', 'like', $search_value)
                        ->orWhere('hari', 'like', $search_value)
                        ->orWhere('jam_mulai', 'like', $search_value)
                        ->orWhere('jam_selesai', 'like', $search_value)
                        ->orWhere('deskripsi', 'like', $search_value);
                });
            }

            // Urutkan dan ambil data
            $data = $query_data->orderBy('id', 'asc')->get();

            // Konfigurasi DataTables
            return datatables()->of($data)
                ->addIndexColumn()
                ->editColumn('hari', function ($row) {
                    // Jika hari tersimpan sebagai string dengan pemisah koma
                    $hari_array = explode(',', $row->hari);
                    // Format ulang menjadi string yang lebih readable
                    return ucwords(implode(', ', $hari_array));
                })
                ->addColumn('action', function ($row) {
                    // Tombol aksi untuk setiap baris data
                    $btn = '
    <form action="' . route('dokters.destroy', $row->id) . '" method="POST">
        <a class="btn btn-info btn-sm" href="' . route('dokters.show', $row->id) . '">Show</a>';

                    if (Auth::user()->can('dokter-edit')) {
                        $btn .= '<a class="btn btn-primary btn-sm" href="' . route('dokters.edit', $row->id) . '">Edit</a>';
                    }

                    if (Auth::user()->can('dokter-delete')) {
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
        return view('dokter.index');
    }








    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('dokter.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|integer',
            'status' => 'required',
            'email' => 'required|unique:dokter',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required',
            'hari' => 'required|array',
            'hari.*' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'deskripsi' => 'required',
        ]);

        $request->merge([
            'hari' => implode(',', $request->hari)
        ]);


        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => '12345678'
        ]);
        if ($user) {
            Dokter::create($request->all());
        }
        return redirect()->back()->with('success', 'insert data berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dokter $dokter)
    {
        return view('dokter.show', compact('dokter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokter $dokter)
    {
        return view('dokter.edit', compact('dokter'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|integer',
            'status' => 'required',
            'email' => 'required|unique:dokter,email,' . $dokter->id,
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required',
            'hari' => 'required|array',
            'hari.*' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'deskripsi' => 'required',
        ]);

        // Gabungkan array hari menjadi string
        $request->merge([
            'hari' => implode(',', $request->hari)
        ]);

        $dokter->update($request->all());
        return redirect()->route('dokters.index')->with('success', 'Data dokter berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->back()->with('success', 'delete data berhasil');
    }
    public function getDokterBySchedule(Request $request)
    {
        $hari = $request->hari;
        $jamKontrol = $request->jam;

        $dokter = Dokter::where('hari', 'like', '%' . $hari . '%')
            ->whereTime('jam_mulai', '<=', $jamKontrol)
            ->whereTime('jam_selesai', '>=', $jamKontrol)
            ->get();

        return response()->json($dokter);
    }
}
