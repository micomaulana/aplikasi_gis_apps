<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kasus DBD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 1.8em;
            margin-bottom: 10px;
            color: #007bff;
        }

        h6 {
            text-align: center;
            font-size: 1em;
            margin: 5px 0;
            color: #555;
        }

        p {
            text-align: center;
            font-size: 1em;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            text-align: left;
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f7f7f7;
            color: #333;
        }

        td {
            font-size: 0.95em;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-header {
            font-size: 1.1em;
            font-weight: bold;
            color: #555;
            margin-bottom: 10px;
            text-decoration: underline;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            font-size: 0.9em;
            font-weight: bold;
            text-align: center;
            border-radius: 12px;
            color: #fff;
        }

        .badge-danger {
            background-color: #dc3545;
            /* Warna merah untuk status berbahaya atau "Positif DBD" */
        }

        .badge-warning {
            background-color: #ffc107;
            /* Warna kuning untuk status waspada */
            color: #333;
        }

        .badge-success {
            background-color: #28a745;
            /* Warna hijau untuk status "Negatif" */
        }

        .badge-info {
            background-color: #17a2b8;
            /* Warna biru untuk status informatif */
        }

        .status {
            width: 15%;
            margin: 0 auto;
            /* Menegahkan tabel secara horizontal */
            text-align: center;
            /* Menegahkan teks di dalam tabel */
            border: none;
            /* Menghilangkan border pada tabel dengan kelas status */
        }

        .status th,
        .status td {
            border: none;
            /* Menghilangkan border pada setiap sel tabel dengan kelas status */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Laporan Kasus DBD</h1>
        <h6>Nomor Laporan: {{ $laporan_kasus_dbd->no_tiket }}</h6>
        {{-- <p>Status:
            
        </p> --}}
        <table class="status">
            <tr>
                <td>Status:</td>
                <td><span class="badge badge-danger">{{ $laporan_kasus_dbd->status }}</span></td>
            </tr>
        </table>

        <div class="info-section">
            <div class="info-header">Informasi Pasien</div>
            <table>
                <tr>
                    <th>Nama Pasien</th>
                    <td>{{ $laporan_kasus_dbd->pasien->nama }}</td>
                </tr>
                <tr>
                    <th>Jadwal Kontrol</th>
                    <td>{{ $laporan_kasus_dbd->jadwal_control }}</td>
                </tr>
                <tr>
                    <th>Dokter Penanggung Jawab</th>
                    <td>{{ $laporan_kasus_dbd->dokter->nama }}</td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td>Puskesmas Karya Maju<br>Jl. Nusantara, Desa Karya Maju</td>
                </tr>
            </table>
        </div>

        <div class="info-section">
            <div class="info-header">Persiapan Kontrol</div>
            <ul>
                <li>Bawa surat pengantar kontrol yang sudah diunduh</li>
                <li>Bawa kartu identitas</li>
                <li>Datang 15 menit sebelum jadwal</li>
            </ul>
        </div>

        <div class="info-section">
            <div class="info-header">Kontak Darurat</div>
            <p>Puskesmas: <strong>(0711) 123456</strong><br>
                Hubungi nomor ini jika terjadi kondisi darurat atau perlu perubahan jadwal.</p>
        </div>
    </div>
</body>

</html>
