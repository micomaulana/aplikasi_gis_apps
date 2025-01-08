<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Statistik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatistikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_desa' => 'required',
                'jumlah_kasus' => 'required',
                'status' => 'required',
                'jumlah_penduduk' => 'required',
                'tanggal_fogging' => 'required',
            ]);
 

            Statistik::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'post success'
            ], 200);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Statistik $statistik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $desas = Desa::all();
        $statistik = Statistik::findOrFail($id);
        return view('data_dan_informasi.edit', compact('desas','statistik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $statistik = Statistik::findOrFail($id);
        $statistik->update($request->all());
        return redirect()->route('data_informasi_view')->with('success', 'update data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $statistik = Statistik::findOrFail($id);
        $statistik->delete();
        return redirect()->back()->with('success', 'update data berhasil');

    }
}
