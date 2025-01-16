@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4">Data Dokter</h1>
        <a class="btn btn-success" href="{{ route('dokters.create') }}">Create New</a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-bordered data-table">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Status</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Jenis Kelamin</th>
                <th>hari</th>
                <th>Jam_mulai</th>
                <th>jam_selesai</th>
                <th>deskripsi</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(function() {
        let table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dokters.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nama', name: 'nama' },
                { data: 'nip', name: 'nip' },
                { data: 'status', name: 'status' },
                { data: 'email', name: 'email' },
                { data: 'alamat', name: 'alamat' },
                { data: 'no_hp', name: 'no_hp' },
                { data: 'jenis_kelamin', name: 'jenis_kelamin' },
                { data: 'hari', name: 'hari' },
                { data: 'jam_mulai', name: 'jam_mulai' },
                { data: 'jam_selesai', name: 'jam_selesai' },
                { data: 'deskripsi', name: 'deskripsi' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return data;
                    }
                }
            ],
            language: {
                processing: "Sedang memproses...",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(disaring dari _MAX_ total data)",
                search: "Cari:",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });
</script>
@endsection
