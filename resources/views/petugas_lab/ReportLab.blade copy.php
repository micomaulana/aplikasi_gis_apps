
@extends('layouts.main')
@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0"><i class="fas fa-flask"></i> Laporan Laboratorium</h5>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Daftar Pasien Laboratorium</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No. Tiket</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Rujukan</th>
                        <th>Status Lab</th>
                        <th>Hasil Lab</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lab_reports as $report)
                    <tr>
                        <td>{{ $report->no_tiket }}</td>
                        <td>{{ $report->pasien->nama }}</td>
                        <td>{{ $report->tanggal_rujukan }}</td>
                        <td>
                            <span class="badge {{ $report->status_lab == 'pending' ? 'bg-warning' : 
                            <span class="badge {{ $report->status_lab == 'pending' ? 'bg-warning' : 
                                              ($report->status_lab == 'uploaded' ? 'bg-info' : 
                                              ($report->status_lab == 'validated' ? 'bg-success' : 'bg-secondary')) }}">
                                {{ $report->status_lab }}
                            </span>
                        </td>
                        <td>
                            @if($report->file_hasil_lab)
                                <a href="/uploads/lab/{{ $report->file_hasil_lab }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            @else
                                <span class="text-muted">Belum diupload</span>
                            @endif
                        </td>
                        <td>
                            @if($report->status_lab == 'pending')
                            <button class="btn btn-success btn-sm upload-lab" data-id="{{ $report->id }}" 
                                    data-bs-toggle="modal" data-bs-target="#uploadLabModal">
                                <i class="fas fa-upload"></i> Upload Hasil
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Upload Hasil Lab -->
<div class="modal fade" id="uploadLabModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Hasil Laboratorium</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="uploadLabForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="report_id" id="report_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File Hasil Lab</label>
                        <input type="file" class="form-control" name="hasil_lab" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="catatan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.upload-lab').click(function() {
        $('#report_id').val($(this).data('id'));
    });

    $('#uploadLabForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '/lab-report/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#uploadLabModal').modal('hide');
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Hasil lab berhasil diupload',
                    icon: 'success'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Terjadi kesalahan saat upload', 'error');
            }
        });
    });
});
</script>
@endsection