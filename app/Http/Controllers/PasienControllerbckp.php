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
    public function index()
    {
        $pasiens = Pasien::paginate(10);
        return view('pasien.index',compact('pasiens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_desas = Desa::all();
        return view('pasien.create', compact ('data_desas'));
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
        ]);
        Pasien::create($request->all());
        return redirect()->back()->with('success','insert data berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pasien $pasien)
    {
        return view('pasien.show',compact('pasien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasien $pasien)
    {
        return view('pasien.edit',compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pasien $pasien)
    {
        $pasien->update($request->all());
        return redirect()->back()->with('success','update data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->back()->with('success','delete data berhasil');
    }
}
