<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DokterController extends Controller
{
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
                        ->orWhere('jenis_kelamin', 'like', $search_value);
                });
            }

            // Urutkan dan ambil data
            $data = $query_data->orderBy('id', 'asc')->get();

            // Konfigurasi DataTables
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // Tombol aksi untuk setiap baris data
                    return '
                    <a class="btn btn-info btn-sm" href="' . route('dokters.show', $row->id) . '">Show</a>
                    <a class="btn btn-primary btn-sm" href="' . route('dokters.edit', $row->id) . '">Edit</a>
                    <form action="' . route('dokters.destroy', $row->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>';
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
        return view('dokter.show', compact('dokters'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokter $dokter)
    {

        return view('dokter.create', compact('dokters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokter $dokter)
    {
        $dokter->update($request->all());
        return redirect()->back()->with('success', 'update data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->back()->with('success', 'delete data berhasil');
    }
}
