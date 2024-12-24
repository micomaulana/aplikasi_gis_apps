<?php

namespace App\Http\Controllers;

use App\Models\LaporanFogging;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanFoggingController extends Controller
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
        // dd($request->all());
        $request->validate([
            'id_desa' => 'required',
            'jumlah_kasus' => 'required',
            'tanggal_pengajuan' => 'required',
            'keterangan' => 'required',
        ]);

        $data = [
            'id_desa' => $request->id_desa,
            'jumlah_kasus' => $request->jumlah_kasus,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'keterangan' => $request->keterangan,
            'status_pengajuan' => "waiting"
        ];

        LaporanFogging::create($data);
        return redirect()->route('laporan_view')->with('success','laporan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporanFogging = LaporanFogging::where('id','=',$id)->with('desa')->first();
        return response()->json([
            'status' => true,
            'message' => "success",
            'data' => $laporanFogging
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaporanFogging $laporanFogging)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LaporanFogging $laporanFogging)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanFogging $laporanFogging)
    {
        //
    }

    public function generatePDF($id){
        $data = LaporanFogging::findOrFail($id);
        $pdf = Pdf::loadView('laporan.laporanfoggingpdf', compact('data'));  // Load a Blade view
        return $pdf->stream('laporanfogging.pdf'); // Download the PDF
    }
}