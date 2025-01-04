<?php

namespace App\Http\Controllers;

use App\Models\OverviewStatistikPublish;
use Illuminate\Http\Request;

class OverviewStatistikPublishController extends Controller
{
    /**
     * Store or update a record in the OverviewStatistikPublish table.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'total_kasus' => 'required|numeric',
            'total_penduduk' => 'required|numeric',
            'total_desa_rawan' => 'required|numeric',
            'jumlah_desa' => 'required|numeric',
        ]);

        try {
            // Cari data pertama di tabel
            $overviewStatistik = OverviewStatistikPublish::first();

            if ($overviewStatistik) {
                // Update jika data sudah ada
                $overviewStatistik->update([
                    'total_kasus' => $request->total_kasus,
                    'total_penduduk' => $request->total_penduduk,
                    'total_desa_rawan' => $request->total_desa_rawan,
                    'jumlah_desa' => $request->jumlah_desa,
                ]);
                $message = 'Overview successfully updated!';
            } else {
                // Buat data baru jika tidak ditemukan
                OverviewStatistikPublish::create($request->all());
                $message = 'Overview successfully published!';
            }

            return redirect()->route('data_informasi_view')->with('success', $message);
        } catch (\Exception $e) {
            // Tangani error
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the aggregated statistics data.
     */
    public function data_informasi_views()
    {
        try {
            $totalkasus = OverviewStatistikPublish::sum("total_kasus");
            $jumlah_keseluruhan_desa_rawan = OverviewStatistikPublish::sum('total_desa_rawan');
            $jumlah_keseluruhan_penduduk_terdampak = OverviewStatistikPublish::sum('total_penduduk');
            $jumlah_desa_terdampak = OverviewStatistikPublish::sum('jumlah_desa');

            return view('data_informasi_views.index', compact(
                'totalkasus',
                'jumlah_keseluruhan_desa_rawan',
                'jumlah_keseluruhan_penduduk_terdampak',
                'jumlah_desa_terdampak'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
