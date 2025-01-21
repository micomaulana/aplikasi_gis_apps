@extends('layouts.main')
@section('content')
    <div class="container-fluid mt-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0"><i class="fas fa-virus"></i> Lapor Kasus DBD</h5>
            <a class="btn btn-success" href="{{ route('tambah_laporan') }}">Tambah laporan</a>
        </div>

        <!-- Status Pengajuan Laporan -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Status pengajuan laporan</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Gejala</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan_dbd as $ldbd)
                            <tr>
                                <td>{{ $ldbd->pasien->nama }}</td>
                                <?php
                                $status = explode(',', $ldbd->status);
                                ?>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $status[0] ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $ldbd->gejala_yang_dialami ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <!-- Tombol untuk melihat detail dan menyembunyikan -->
                                    <button class="btn btn-outline-primary btn-sm btn-lihat"
                                        data-id="{{ $ldbd->pasien->id }}">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm btn-hide" data-id="{{ $ldbd->pasien->id }}"
                                        style="display: none;">
                                        <i class="fas fa-eye-slash"></i> Hide
                                    </button>
                                    {{-- <a href="" class="text-primary">
                                        <i class="fas fa-file-pdf"></i> Unduh PDF
                                    </a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Preview Laporan -->
        <div class="card" id="preview-laporan">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Preview laporan</h6>
                <div>
                    <button class="btn btn-outline-primary me-2"
                        onclick="window.location.href='/printLaporanMasyarakat/' + $('#id_laporan').val()">
                        <i class="fas fa-print"></i> Cetak
                    </button>
                    <button class="btn btn-outline-primary unduh"><i class="fas fa-file-pdf"></i> Unduh pdf</button>
                </div>
            </div>
            <div class="card-body">
                <input type="text" id="id_laporan" hidden>
                <h6>Laporan #<span id="no_tiket"></span></h6>
                <p>Status: <strong class="text-danger" id="status">Positif DBD</strong></p>
                <h6>Jadwal Kontrol</h6>
                <p><i class="fas fa-calendar-alt"></i> Tanggal Dan Waktu<br><strong id="jadwal_control">24 Maret 2024, 09:00
                        WIB</strong></p>
                <p><i class="fas fa-calendar-alt"></i> Nama<br><strong id="nama_pasien"></strong></p>
                <p><i class="fas fa-user-md"></i> Dokter Penanggung Jawab<br><strong id="dokter_pj">Dr. Syarief
                        Ananta</strong></p>
                <p><i class="fas fa-map-marker-alt"></i> Lokasi<br><strong>Puskesmas Karya Maju<br>Jl. Nusantara, Desa Karya
                        Maju</strong></p>
                <h6>Persiapan Kontrol</h6>
                <ul>
                    <li><i class="fas fa-file-alt"></i> Bawa surat pengantar kontrol yang sudah diunduh</li>
                    <li><i class="fas fa-id-card"></i> Bawa kartu identitas</li>
                    <li><i class="fas fa-clock"></i> Datang 15 menit sebelum jadwal</li>
                </ul>
                <h6>Kontak Darurat</h6>
                <p><i class="fas fa-phone"></i> Puskesmas: <strong>(0711) 123456</strong><br>Hubungi nomor ini jika terjadi
                    kondisi darurat atau perlu perubahan jadwal</p>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#preview-laporan').hide();

            $('.btn-lihat').click(function() {
                let id_pasien = $(this).data('id');
                let btnHide = $(this).siblings('.btn-hide');
                let btnLihat = $(this);

                btnLihat.hide();
                btnHide.show();
                $('#preview-laporan').show();

                $.ajax({
                    url: '/get_laporan_dbd_by_id_pasien/' + id_pasien,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $("#id_laporan").val(response.data.id);
                        $("#nama_pasien").html(response.data.pasien.nama);
                        $("#no_tiket").html(response.data.no_tiket);
                        $("#status").html(response.data.status).css("text-transform",
                            "uppercase");
                        $("#jadwal_control").html(response.data.jadwal_control);
                        $("#dokter_pj").html(response.data.dokter.nama);
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan:', error);
                    }
                });
            });

            $('.btn-hide').click(function() {
                let btnLihat = $(this).siblings('.btn-lihat');
                let btnHide = $(this);

                btnHide.hide();
                btnLihat.show();
                $('#preview-laporan').hide();
            });

            $(".unduh").click(function() {
                let id_laporan = $("#id_laporan").val();
                window.location.href = "/generatePDFLaporan/" + id_laporan;
            });

            $('.btn-outline-primary[title="Cetak"]').click(function() {
                let id_laporan = $("#id_laporan").val();
                // Buka dalam window baru
                window.open(`/printLaporanMasyarakat/${id_laporan}`, '_blank');
            });
        });
    </script>
@endsection
