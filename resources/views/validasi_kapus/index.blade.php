@extends('layouts.main')
@section('content')
    <div class="container-fluid mt-5">
        <div class="card custom-card shadow-card">
            <div class="card-header">
                Validasi laporan Foggings
            </div>
            <div class="card-body custom-card-body">
                <div>
                    <h6>Total laporan</h6>
                    <h3>{{ $jumlah_laporan }}</h3>
                </div>
                <div>
                    <h6>Menunggu Validasi</h6>
                    <h3>{{ $jumlah_laporan_menunggu_validasi }}</h3>
                </div>
                <div>
                    <h6>Terkonfirmasi</h6>
                    <h3>{{ $jumlah_laporan_terkonfirmasi }}</h3>
                </div>
                <div>
                    <h6>Ditolak</h6>
                    <h3>{{ $jumlah_laporan_rejected }}</h3>
                </div>
            </div>
        </div>

        <h5 class="mt-4">Daftar Laporan</h5>
        <table class="table table-bordered mt-2 custom-table">
            <thead class="table-light">
                <tr>
                    <th>Desa</th>
                    <th>Jumlah Kasus</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanfoggings as $laporan)
                    <tr>
                        <!-- Menampilkan nama desa -->
                        <td>{{ $laporan->desa->nama }} </td>
                        <!-- Menampilkan jumlah kasus -->
                        <td>{{ $laporan->jumlah_kasus }}</td>
                        <!-- Menampilkan tanggal persetujuan -->
                        <td>{{ $laporan->tanggal_persetujuan ?? 'N/A' }}</td>
                        <!-- Menampilkan status pengajuan -->
                        <td>{{ $laporan->status_pengajuan ?? 'N/A' }}</td>
                        <td>
                            @if ($laporan->status_pengajuan == 'waiting')
                                <a href="{{ route('update_status_pengajuan_fogging', ['id' => $laporan->id, 'status' => 'setuju']) }}"
                                    class="btn" id="button-setuju">Setuju</a>
                                <a href="{{ route('update_status_pengajuan_fogging', ['id' => $laporan->id, 'status' => 'tolak']) }}"
                                    class="btn" id="button-tolak">Tolak</a>
                            @else
                                <a class="btn btn-info lihat_detail"  data-id="{{ $laporan->id }}">Lihat</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <div class="container mt-3" id="detail_laporan">
            <form action="">
                <h3>Detail Laporan</h3>
                <button type="button" id="tutup_detail" class="btn btn-danger">Tutup</button>
                <div class="row g-3">
                    <!-- Input 1 -->
                    <div class="col-md-6">
                        <label for="input1" class="form-label">Desa</label>
                        <input type="text" class="form-control" id="desa" name="input1">
                    </div>
                    <!-- Input 2 -->
                    <div class="col-md-6">
                        <label for="input2" class="form-label">Jumlah Kasus</label>
                        <input type="text" class="form-control" id="jumlah_kasus" name="input2">
                    </div>
                    <!-- Input 3 -->
                    <div class="col-md-6">
                        <label for="input3" class="form-label">Tanggal Pengajuan</label>
                        <input type="text" class="form-control" id="input3" name="input3">
                    </div>
                    <!-- Input 4 -->
                    <div class="col-md-6">
                        <label for="input4" class="form-label">Tanggal Persetujuan</label>
                        <input type="text" class="form-control" id="input4" name="input4">
                    </div>
                    <!-- Input 5 -->
                    <div class="col-md-6">
                        <label for="input5" class="form-label">Status Pengajuan</label>
                        <input type="text" class="form-control" id="input5" name="input5">
                    </div>
                    <!-- Input 6 -->
                    <div class="col-md-6">
                        <label for="input6" class="form-label">Jumlah Pasien</label>
                        <input type="text" class="form-control" id="pasien_di_desa" name="input6">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#detail_laporan').hide();
            $('.lihat_detail').click(function() {
                const id_laporan = $(this).data('id');  // Ambil id_desa dari input atau elemen lain
                $.ajax({
                    url: '/lihat_detail_foggings/' + id_laporan,
                    method: 'GET',
                    success: function(response) {
                        $('#detail_laporan').show();

                        const data = response.data;
                        console.log(data);

                        // Akses data berdasarkan id_desa (misalnya data[id_desa])
                        if (data.length > 0) {
                            // Mengambil data desa
                            const laporan = data[
                                0
                            ]; // Mengambil laporan pertama karena data di-group berdasarkan id_desa

                            const desaName = laporan.desa.nama || ''; // Nama desa
                            const jumlahKasus = laporan.jumlah_kasus || ''; // Jumlah kasus
                            const tanggalPengajuan = formatDate(laporan.tanggal_pengajuan) ||
                                ''; // Tanggal Pengajuan
                            const tanggalPersetujuan = formatDate(laporan
                                .tanggal_persetujuan) ||
                                ''; // Tanggal Persetujuan
                            const statusPengajuan = laporan.status_pengajuan ||
                                ''; // Status Pengajuan
                            const jumlahPasien = laporan.desa.pasien.length ||
                                0; // Jumlah Pasien

                            // Menampilkan data pada form
                            $('#desa').val(desaName);
                            $('#jumlah_kasus').val(jumlahKasus);
                            $('#input3').val(tanggalPengajuan);
                            $('#input4').val(tanggalPersetujuan);
                            $('#input5').val(statusPengajuan);
                            $('#pasien_di_desa').val(jumlahPasien);
                        } else {
                            console.log('Data tidak ditemukan untuk id_desa: ' + id_desa);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });

            // Fungsi untuk format tanggal menjadi 'd m y'
            function formatDate(dateString) {
                if (!dateString) return ''; // Jika tidak ada tanggal
                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0'); // Menambahkan 0 di depan jika kurang dari 10
                const month = String(date.getMonth() + 1).padStart(2,
                    '0'); // Bulan dimulai dari 0, jadi kita tambahkan 1
                const year = date.getFullYear(); // Mendapatkan tahun

                return `${day} ${month} ${year}`;
            }
            $('#tutup_detail').click(function() {
                $('#detail_laporan').hide(); // Menyembunyikan detail laporan
            });
        });
    </script>
@endsection
