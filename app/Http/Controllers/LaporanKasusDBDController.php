<?php

namespace App\Http\Controllers;

use App\Models\LaporaKasusDbd;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanKasusDBDController extends Controller
{
    public function index() {}

    public function update(Request $request, $id)
    {
        // dd($request->all());
        try {
            $request->validate([
                'status' => 'required',
                'tanggal_control' => 'required',
                'waktu_control' => 'required',
                'id_dokter' => 'required',
                'catatan' => 'string|nullable'
            ]);


            $laporan_kasus_dbd = LaporaKasusDbd::where('id_pasien', '=', $id)->get();
            $jadwalControl = $request->tanggal_control . '-' . $request->waktu_control;
            foreach ($laporan_kasus_dbd as $key => $value) {
                $value->update([
                    'status' => $request->status,
                    'jadwal_control' => $jadwalControl,
                    'dokter_pj' => $request->id_dokter,
                ]);
            }

            return response()->json([
                'message' => 'Laporan berhasil diterima!',
                'data' => $request->all()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 200);
        }
    }
    public function validasiLaporan(Request $request)
    {
        // Validasi data input
        $data = $request->validate([
            'status' => 'required',
            'tanggal_control' => 'required',
            'waktu_control' => 'required',
            'id_dokter' => 'required',
            'catatan' => 'string|nullable'
        ]);

        // Simpan data (opsional, jika ada database)
        // Example: Model::create($data);

        return response()->json([
            'message' => 'Laporan berhasil diterima!',
            'data' => $data,
        ]);
    }
    public function generatePDF($id)
    {
        $laporan_kasus_dbd = LaporaKasusDbd::findOrFail($id);
        $pdf = Pdf::loadView('laporan_masyarakat.lapordbdpdf', compact('laporan_kasus_dbd'));  // Load a Blade view
        return $pdf->stream('laporanDBD.pdf'); // Download the PDF
    }

    public function printLaporanMasyarakat($id)
    {
        $laporan_kasus_dbd = LaporaKasusDbd::with(['pasien', 'dokter'])->where('id', '=', $id)->first();
        // dd($laporan_kasus_dbd);
        return view('laporan_masyarakat.print-laporan-dbd', ['laporan_kasus_dbd' => $laporan_kasus_dbd]);
    }

    public function detail_laporan_masyarakat($id_pasien)
    {
        $detaillaporanbyidpasien = LaporaKasusDbd::select(
            DB::raw("DATE(created_at) as tanggal"), // Mengambil tanggal dari created_at
            DB::raw("YEAR(created_at) as tahun"),   // Mengambil tahun dari created_at
            'id_pasien',
            DB::raw("GROUP_CONCAT(gejala_yang_dialami SEPARATOR ', ') as gejala") // Menggabungkan gejala
        )
            ->where('id_pasien', '=', $id_pasien)
            ->groupBy('tanggal', 'tahun', 'id_pasien')
            ->get();
        return view('laporan_masyarakat.detail-laporan', compact('detaillaporanbyidpasien'));
    }
}
