<?php

namespace App\Http\Controllers;

use App\Models\LaporaKasusDbd;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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
}
