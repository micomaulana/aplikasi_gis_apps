<?php

namespace App\Http\Controllers;

use App\Models\OverviewStatistikPublish;
use Illuminate\Http\Request;

class OverviewStatistikPublishController extends Controller
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
        $request->validate([
            'id_desa' => 'required',
            'total_kasus' => 'required',
            'total_penduduk' => 'required',
            'total_desa_rawan' => 'required',
            'jumlah_desa' => 'required',
        ]);
        OverviewStatistikPublish::create($request->all());
        return redirect()->route('data_informasi_view')->with('success', 'overview success to published');
    }
    public function data_informasi_views()
    {
        $totalkasus = OverviewStatistikPublish::count();
        $jumlah_keseluruhan_desa_rawan = OverviewStatistikPublish::sum('total_desa_rawan');
        $jumlah_keseluruhan_penduduk_terdampak = OverviewStatistikPublish::distinct('id_desa')->sum('total_penduduk');
        $jumlah_desa_terdampak = OverviewStatistikPublish::distinct('id_desa')->count();
        return view('data_informasi_views.index',compact('totalkasus','jumlah_keseluruhan_desa_rawan','jumlah_keseluruhan_penduduk_terdampak','jumlah_desa_terdampak'));
    }
    /**
     * Display the specified resource.
     */
    public function show(OverviewStatistikPublish $overviewStatistikPublish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OverviewStatistikPublish $overviewStatistikPublish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OverviewStatistikPublish $overviewStatistikPublish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OverviewStatistikPublish $overviewStatistikPublish)
    {
        //
    }
}
