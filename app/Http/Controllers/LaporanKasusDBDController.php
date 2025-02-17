<?php

namespace App\Http\Controllers;

use App\Models\LaporaKasusDbd;
use App\Models\LaporanKasusDBD;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanKasusDBDController extends Controller
{
    public function index() {}

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required',
                'tanggal_control' => 'required',
                'waktu_control' => 'required',
                'id_dokter' => 'required',
                'catatan' => 'string|nullable'
            ]);

            // Cari laporan spesifik berdasarkan id
            $laporan = LaporaKasusDbd::findOrFail($id);
            $jadwalControl = $request->tanggal_control . ' ' . $request->waktu_control;

            // Update hanya satu laporan
            $laporan->update([
                'status' => $request->status,
                'jadwal_control' => $jadwalControl,
                'dokter_pj' => $request->id_dokter,
            ]);

            return response()->json([
                'message' => 'Laporan berhasil divalidasi!',
                'data' => $laporan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
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
        $laporan_kasus_dbd = LaporaKasusDbd::with(['pasien', 'dokter'])
            ->where('id', '=', $id)
            ->firstOrFail();

        // Tambahkan pengecekan status jika diperlukan
        // if ($laporan_kasus_dbd->status !== 'dbd' && $laporan_kasus_dbd->status !== 'suspect') {
        //     return response()->json([
        //         'message' => 'PDF hanya bisa digenerate untuk status DBD atau suspect',
        //     ], 400);
        // }

        $pdf = Pdf::loadView('laporan_masyarakat.lapordbdpdf', compact('laporan_kasus_dbd'));

        // Menambahkan nama file yang lebih deskriptif
        $filename = 'Laporan_DBD_' . $laporan_kasus_dbd->no_tiket . '.pdf';

        return $pdf->stream($filename);
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
    public function update_by_lab(Request $request)
    {
        $request->validate([
            'file_hasil_lab' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required'
        ]);
        $file = $request->file('file_hasil_lab');
        $id = $request->id;
        // Tentukan nama file unik
        // Nama file kustom
        $filename = 'hasil_lab_' . time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('hasil_lab');
        $file->move($destinationPath, $filename);

        LaporanKasusDBD::where('id', '=', $id)->update([
            'file_hasil_lab' => $filename,
            'status' => $request->status
        ]);

        return redirect()->route('validasi_admin')->with('success', 'laporan updated successfully');
    }

    public function accept_lab_by_admin(Request $request,$id)
    {
        $laporan_kasus_dbd = LaporaKasusDbd::with(['pasien','dokter'])->where('id','=',$id)->first();
        return response()->json([
            'success' => true,
            'data' => $laporan_kasus_dbd
        ]);
        // Tentukan nama file unik
        // LaporanKasusDBD::where('id', '=', $id)->update([
        //     'status' => $request->status
        // ]);

        // return redirect()->route('validasi_admin')->with('success', 'laporan updated successfully');
    }
}
