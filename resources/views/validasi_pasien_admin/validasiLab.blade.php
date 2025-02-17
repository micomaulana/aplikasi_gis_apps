{{-- admin_lab_validation.blade.php - For admin to validate lab results --}}
@extends('layouts.main')
@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0"><i class="fas fa-check-double"></i> Validasi Hasil Lab</h5>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Daftar Hasil Lab Menunggu Validasi</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No. Tiket</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal Upload</th>
                            <th>Hasil Lab</th>
                            <th>Catatan Lab</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pending_validations as $report)
                            <tr>
                                <td>{{ $report->no_tiket }}</td>
                                <td>{{ $report->pasien->nama }}</td>
                                <td>{{ $report->tanggal_upload }}</td>
                                <td>
                                    <a href="/uploads/lab/{{ $report->file_hasil_lab }}" target="_blank"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-file-medical"></i> Lihat Hasil
                                    </a>
                                </td>
                                <td>{{ $report->catatan_lab }}</td>
                                <td>
                                    <button class="btn btn-success btn-sm validate-lab" data-id="{{ $report->id }}"
                                        data-bs-toggle="modal" data-bs-target="#validateLabModal">
                                        <i class="fas fa-check"></i> Validasi
                                    </button>
                                    <button class="btn btn-danger btn-sm reject-lab" data-id="{{ $report->id }}">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Validasi -->
    <div class="modal fade" id="validateLabModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Validasi Hasil Lab</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="validateLabForm">
                    @csrf
                    <input type="hidden" name="report_id" id="validate_report_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Catatan Validasi</label>
                            <textarea class="form-control" name="catatan_validasi" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Validasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.validate-lab').click(function() {
                $('#validate_report_id').val($(this).data('id'));
            });

            $('#validateLabForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: '/lab-report/validate',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#validateLabModal').modal('hide');
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Hasil lab telah divalidasi',
                            icon: 'success'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Terjadi kesalahan saat validasi', 'error');
                    }
                });
            });

            $('.reject-lab').click(function() {
                const reportId = $(this).data('id');

                Swal.fire({
                    title: 'Konfirmasi Penolakan',
                    text: 'Apakah Anda yakin ingin menolak hasil lab ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Tolak',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/lab-report/reject/' + reportId,
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire('Berhasil!', 'Hasil lab telah ditolak',
                                        'success')
                                    .then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', 'Terjadi kesalahan saat menolak',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
