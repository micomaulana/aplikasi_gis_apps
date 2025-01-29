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
                    <th>Tanggal Pengajuan</th>
                    <th>Tanggal Persetujuan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanfoggings as $laporan)
                    <tr>
                        <td>{{ $laporan->desa->nama }}</td>
                        <td>{{ $laporan->jumlah_kasus }}</td>
                        <td>{{ $laporan->tanggal_pengajuan ? date('d-m-Y', strtotime($laporan->tanggal_pengajuan)) : 'N/A' }}
                        </td>
                        <td>{{ $laporan->tanggal_persetujuan ? date('d-m-Y', strtotime($laporan->tanggal_persetujuan)) : 'N/A' }}
                        </td>
                        <td>
                            <span
                                class="badge {{ $laporan->status_pengajuan == 'waiting'
                                    ? 'bg-warning'
                                    : ($laporan->status_pengajuan == 'disetujui'
                                        ? 'bg-success'
                                        : 'bg-danger') }}">
                                {{ $laporan->status_pengajuan ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="keterangan-cell" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="{{ $laporan->keterangan ?? 'N/A' }}">
                            {{ $laporan->keterangan ?? 'N/A' }}
                        </td>
                        <td>
                            @if ($laporan->status_pengajuan == 'waiting')
                                <a href="{{ route('update_status_pengajuan_fogging', ['id' => $laporan->id, 'status' => 'setuju']) }}"
                                    class="btn btn-success btn-sm">Setuju</a>
                                <a href="{{ route('update_status_pengajuan_fogging', ['id' => $laporan->id, 'status' => 'tolak']) }}"
                                    class="btn btn-danger btn-sm">Tolak</a>
                            @else
                                <button class="btn btn-info btn-sm lihat_detail"
                                    data-id="{{ $laporan->id }}">Lihat</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="container mt-3" id="detail_laporan">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Laporan</h5>
                    <button type="button" id="tutup_detail" class="btn btn-danger btn-sm">Tutup</button>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="desa" class="form-label">Desa</label>
                                <input type="text" class="form-control" id="desa" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="jumlah_kasus" class="form-label">Jumlah Kasus</label>
                                <input type="text" class="form-control" id="jumlah_kasus" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                                <input type="text" class="form-control" id="tanggal_pengajuan" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_persetujuan" class="form-label">Tanggal Persetujuan</label>
                                <input type="text" class="form-control" id="tanggal_persetujuan" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="status_pengajuan" class="form-label">Status Pengajuan</label>
                                <input type="text" class="form-control" id="status_pengajuan" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="pasien_di_desa" class="form-label">Jumlah Pasien</label>
                                <input type="text" class="form-control" id="pasien_di_desa" readonly>
                            </div>
                            <div class="col-12">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" rows="3" readonly></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Inisialisasi tooltip Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            $('#detail_laporan').hide();

            $('.lihat_detail').click(function() {
                const id_laporan = $(this).data('id');
                $.ajax({
                    url: '/lihat_detail_foggings/' + id_laporan,
                    method: 'GET',
                    success: function(response) {
                        $('#detail_laporan').show();
                        const data = response.data;

                        if (data.length > 0) {
                            const laporan = data[0];

                            $('#desa').val(laporan.desa.nama || '');
                            $('#jumlah_kasus').val(laporan.jumlah_kasus || '');
                            $('#tanggal_pengajuan').val(formatDate(laporan.tanggal_pengajuan) ||
                                '');
                            $('#tanggal_persetujuan').val(formatDate(laporan
                                .tanggal_persetujuan) || '');
                            $('#status_pengajuan').val(laporan.status_pengajuan || '');
                            $('#pasien_di_desa').val(laporan.desa.pasien.length || 0);
                            $('#keterangan').val(laporan.keterangan || '');
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });

            function formatDate(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                return `${String(date.getDate()).padStart(2, '0')}-${String(date.getMonth() + 1).padStart(2, '0')}-${date.getFullYear()}`;
            }

            $('#tutup_detail').click(function() {
                $('#detail_laporan').hide();
            });
        });
    </script>

    <style>
        .custom-table td {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .keterangan-cell {
            cursor: pointer;
        }

        /* Custom tooltip style */
        .tooltip .tooltip-inner {
            max-width: 350px;
            text-align: left;
            padding: 10px;
            background-color: #f8f9fa;
            color: #212529;
            border: 1px solid #dee2e6;
            font-size: 14px;
        }
    </style>
@endsection
