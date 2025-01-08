<?php

namespace App\Http\Controllers;

use App\Models\OverviewStatistikPublish;
use App\Models\Statistik;
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
            'tahun' => 'required|numeric'
        ]);

        try {
            // Cari data pertama di tabel
            $overviewStatistik = OverviewStatistikPublish::where('tahun', '=', $request->tahun)->first();

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
            $statistik = Statistik::with('desa')->get();

            return view('data_informasi_views.index', compact(
                'totalkasus',
                'jumlah_keseluruhan_desa_rawan',
                'jumlah_keseluruhan_penduduk_terdampak',
                'jumlah_desa_terdampak',
                'statistik'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function getDataByYear($year)
    {
        $overviewStatistik = OverviewStatistikPublish::where('tahun', '=', $year)->get();
        $data = [];
        if (empty($overviewStatistik)) {
            $data = [
                'total_kasus' => 0,
                'jumlah_keseluruhan_desa_rawan' => 0,
                'jumlah_keseluruhan_penduduk_terdampak' => 0,
                'jumlah_desa_terdampak' => 0
            ];
        } else {
            $totalkasus = OverviewStatistikPublish::where('tahun', '=', $year)->sum("total_kasus");
            $jumlah_keseluruhan_desa_rawan = OverviewStatistikPublish::where('tahun', '=', $year)->sum('total_desa_rawan');
            $jumlah_keseluruhan_penduduk_terdampak = OverviewStatistikPublish::where('tahun', '=', $year)->sum('total_penduduk');
            $jumlah_desa_terdampak = OverviewStatistikPublish::where('tahun', '=', $year)->sum('jumlah_desa');
            $data = [
                'total_kasus' => $totalkasus,
                'jumlah_keseluruhan_desa_rawan' => $jumlah_keseluruhan_desa_rawan,
                'jumlah_keseluruhan_penduduk_terdampak' =>  $jumlah_keseluruhan_penduduk_terdampak,
                'jumlah_desa_terdampak' => $jumlah_desa_terdampak
            ];
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function getDataStatistikByYear($year)
    {
        $statistik = Statistik::whereYear('tanggal_fogging', '=', $year)->with('desa')->get();
        return response()->json([
            'status' => 'success',
            'data' => $statistik
        ], 200);
    }
    public function getDataStatistikFormByYear($year)
    {
        $statistik = Statistik::whereYear('tanggal_fogging', '=', $year)->get();

        // Menjumlahkan jumlah kasus dan jumlah penduduk
        $totalKasus = $statistik->sum('jumlah_kasus');
        $jumlahPenduduk = $statistik->sum('jumlah_penduduk');

        // Menghitung jumlah desa (distinct berdasarkan id_desa)
        $jumlahDesa = $statistik->unique('id_desa')->count();

        // Menghitung jumlah desa dengan status 'tinggi'
        $jumlahDesaRawan = $statistik->filter(function ($stat) {
            // Memeriksa apakah nilai status sama dengan 'tinggi'
            return $stat->status === 'tinggi';
        })->count();

        // Menyusun data
        $data = [
            'total_kasus' => $totalKasus,
            'jumlah_penduduk' => $jumlahPenduduk,
            'jumlah_desa' => $jumlahDesa,
            'jumlah_desa_rawan' => $jumlahDesaRawan,
            'tanggal_fogging' => $statistik[0]['tanggal_fogging']
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }
}
