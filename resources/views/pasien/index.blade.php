@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <label for="year_filter" class="form-label mb-2">Filter Tahun:</label>
                    <select class="form-control" id="year_filter" style="width: 200px;">
                        <option value="">Semua Tahun</option>
                        @php
                            $currentYear = date('Y');
                            $startYear = 2022;
                            for ($year = $currentYear; $year >= $startYear; $year--) {
                                echo "<option value='" . $year . "'>" . $year . '</option>';
                            }
                        @endphp
                    </select>
                </div>
            </div>
            <div class="col-md-6 text-end">
                @can('pasien-create')
                    <a class="btn btn-success" href="{{ route('pasiens.create') }}">
                        <i class="fas fa-plus"></i> Tambah Pasien Baru
                    </a>
                @endcan
            </div>
        </div>

        <!-- Alert Messages -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p class="mb-0">{{ $message }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Table Section -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover data-table">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>nama</th>
                            <th>jenis_kelamin</th>
                            <th>tempat_lahir</th>
                            <th>tanggal_lahir</th>
                            {{-- <th>usia</th> --}}
                            <th>alamat</th>
                            <th>Nama Desa</th>
                            {{-- <th>provinsi</th> --}}
                            {{-- <th>kab_kota</th> --}}
                            {{-- <th>diagnosis_lab</th> --}}
                            {{-- <th>diagnosis_klinis</th> --}}
                            {{-- <th>status_akhir</th> --}}
                            {{-- <th>email</th> --}}
                            {{-- <th>no_hp</th> --}}
                            <th>tahun_terdata</th>
                            <th width="200px">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pasiens.index') }}",
                    data: function(d) {
                        d.year = $('#year_filter').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'NIK',
                        name: 'NIK'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin'
                    },
                    {
                        data: 'tempat_lahir',
                        name: 'tempat_lahir'
                    },
                    {
                        data: 'tanggal_lahir',
                        name: 'tanggal_lahir'
                    },
                    // { data: 'usia', name: 'usia' },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'nama_desa',
                        name: 'nama_desa'
                    },
                    // { data: 'provinsi', name: 'provinsi' },
                    // { data: 'kab_kota', name: 'kab_kota' },
                    // { data: 'diagnosis_lab', name: 'diagnosis_lab' },
                    // { data: 'diagnosis_klinis', name: 'diagnosis_klinis' },
                    // { data: 'status_akhir', name: 'status_akhir' },
                    // { data: 'email', name: 'email' },
                    // { data: 'no_hp', name: 'no_hp' },
                    {
                        data: 'tahun_terdata',
                        name: 'tahun_terdata'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [8,
                    'desc'] // Mengurutkan berdasarkan kolom tahun_terdata (index 8) secara descending
                ],
                language: {
                    processing: "Memproses...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data yang ditampilkan",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            // Reload table when year filter changes
            $('#year_filter').change(function() {
                table.draw();
            });
        });
    </script>
@endsection
