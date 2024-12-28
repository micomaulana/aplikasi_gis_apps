@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <div class="pull-right">
            <a class="btn btn-success" href=" {{ route('pasiens.create') }}"> create new </a>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>nama</th>
                    <th>alamat</th>
                    <th>email</th>
                    <th>usia</th>
                    <th>Nama Desa</th>
                    <th>provinsi</th>
                    <th>kab_kota</th>
                    <th>tempat_lahir</th>
                    {{-- <th>tanggal_lahir</th> --}}
                    {{-- <th>jenis_kelamin</th> --}}
                    {{-- <th>diagnosis_lab</th> --}}
                    {{-- <th>diagnosis_klinis</th> --}}
                    {{-- <th>status_akhir</th> --}}
                       {{-- <th>no_hp</th> --}}
                    {{-- <th>tahun_terdata</th> --}}
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('pasiens.index') }}",

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },

                    {
                        data: 'nama',
                        name: 'nama'
                    },

                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {

                        data: 'usia',
                        name: 'usia'
                    },
                    {

                        data: 'nama_desa',
                        name: 'nama_desa'
                    },
                    {
                        data: 'provinsi',
                        name: 'provinsi'
                    },
                    {
                        data: 'kab_kota',
                        name: 'kab_kota'
                    },
                    {
                        data: 'tempat_lahir',
                        name: 'tempat_lahir'
                    },
                    // {

                    //     data: 'tanggal_lahir',
                    //     name: 'tanggal_lahir'
                    // },
                    // {

                    //     data: 'jenis_kelamin',
                    //     name: 'jenis_kelamin'
                    // },
                    // {

                    //     data: 'diagnosis_lab',
                    //     name: 'diagnosis_lab'
                    // },
                    // {

                    //     data: 'diagnosis_klinis',
                    //     name: 'diagnosis_klinis'
                    // },
                    // {

                    //     data: 'status_akhir',
                    //     name: 'status_akhir'
                    // },
                    // {
                    //     data: 'no_hp',
                    //     name: 'no_hp'
                    // },
                    // {
                    //     data: 'tahun_terdata',
                    //     name: 'tahun_terdata'
                    // },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]

            });
        });
    </script>
@endsection
