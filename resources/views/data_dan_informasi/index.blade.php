@extends('layouts.main')
@section('content')
    <div class="container-fluid mt-5">
        <h1>Halaman Data Informasi</h1>
        <div class="header">
            <i class="fas fa-info-circle"></i> Data dan Informasi
        </div>

        <div class="card p-4 mb-4">
            <form id="form_data_statistic">
                {{-- <div class="mb-3">
                    <select class="form-select" name="year_created" aria-label="Select year" id="yearSelect">
                    </select>
                </div> --}}
                <h5 class="card-title">Input data statistik</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="desa" class="form-label">Nama desa</label>
                        <select id="desa" class="form-select" name="id_desa">
                            <option selected>Pilih desa</option>
                            @foreach ($desas as $desa)
                                <option value="{{ $desa->id }}">{{ $desa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="kasus" class="form-label">Jumlah kasus</label>
                        <input type="number" name="jumlah_kasus" id="kasus" class="form-control"
                            placeholder="Masukkan jumlah kasus">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select">
                            <option selected>Pilih status</option>
                            <option value="tinggi">Tinggi</option>
                            <option value="rendah">Rendah</option>
                            <option value="sedang">Sedang</option>

                            <!-- Add other status options as needed -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="penduduk" class="form-label">Jumlah penduduk</label>
                        <input type="number" id="penduduk" name="jumlah_penduduk" class="form-control"
                            placeholder="Masukkan jumlah penduduk">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fogging" class="form-label">Tanggal fogging terakhir</label>
                        <input type="date" id="fogging" name="tanggal_fogging" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary d-flex ms-auto">Simpan data</button>
            </form>
        </div>


        <<div class="card p-4 mb-4">

            <h5 class="card-title d-flex justify-content-between align-items-center">
                <span>Preview data</span>
                <select class="form-select" aria-label="Select year" id="yearSelect" style="width: 350px;">
                </select>
                <a class="btn btn-success publish_data" style="margin-right: 10px;">Publish Data</a>
            </h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Desa</th>
                        <th>Kasus</th>
                        <th>Status</th>
                        <th>Penduduk</th>
                        <th>Fogging terakhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($statistiks as $statistik)
                        <tr>
                            <td>{{ $statistik->desa->nama }}</td>
                            <td>{{ $statistik->jumlah_kasus }}</td>
                            <td>{{ $statistik->status }}</td>
                            <td>{{ $statistik->jumlah_penduduk }}</td>
                            <td>{{ $statistik->tanggal_fogging }}</td>
                            <td>
                                <form action="{{ route('delete-data-statistik', $statistik->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('edit_data_statistik', $statistik->id) }}"
                                        class="btn btn-secondary">Edit</a>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>

    <form action="{{ route('publish_overview_statistiks.store') }}" method="POST" id="form-publish">
        @csrf
        <div class="card p-4 mb-4">
            <h5 class="card-title">Overview statistik</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="overview-card">
                        <label for="total" class="form-label">total kasus</label>
                        <input type="number" name="total_kasus" id="kasus" class="form-control"
                            placeholder="Masukkan jumlah kasus">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="overview-card">
                        <label for="desa_rawan" class="form-label">desa rawan</label>
                        <input type="number" name="total_desa_rawan" id="desa_rawan" class="form-control"
                            placeholder="Masukkan jumlah desa">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="overview-card">
                        <label for="total" class="form-label">total penduduk</label>
                        <input type="number" name="total_penduduk" id="total" class="form-control"
                            placeholder="Masukkan jumlah total">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="overview-card">
                        <label for="jumlah" class="form-label">jumlah desa</label>
                        <input type="number" name="jumlah_desa" id="jumlah" class="form-control"
                            placeholder="Masukkan jumlah desa">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="overview-card">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" name="tahun" id="jumlah" class="form-control"
                            placeholder="Masukkan tahun">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary d-flex ms-auto">publikasikan data</button>
        </div>
    </form>
    </div>

    <script>
        $(document).ready(function() {
            // Year selection setup
            var currentYear = new Date().getFullYear();
            var startYear = 2000;
            var yearSelect = $('#yearSelect');

            for (var year = currentYear; year >= startYear; year--) {
                yearSelect.append(new Option(year, year));
            }
            $("#form-publish").hide();

            // Form submission for statistics data
            $("#form_data_statistic").submit(function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('simpan_statistic') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: "Success",
                                text: "Data Berhasil Disimpan",
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                            $('#form_data_statistic')[0].reset();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan. Silakan coba lagi.",
                            icon: "error"
                        });
                    }
                });
            });

            // Overview calculation
            $('.publish_data').click(function() {
                $("#form-publish").show();
                calculateOverview();
            });

            // Function to calculate overview from table data
            function calculateOverview() {
                let totalKasus = 0;
                let totalPenduduk = 0;
                let totalDesaRawan = 0;
                let totalDesa = 0;

                // Get current year
                const selectedYear = $('#yearSelect').val();

                // Iterate through table rows
                $('.table tbody tr').each(function() {
                    // Get values from each row
                    const kasus = parseInt($(this).find('td:eq(1)').text()) || 0;
                    const status = $(this).find('td:eq(2)').text().toLowerCase();
                    const penduduk = parseInt($(this).find('td:eq(3)').text()) || 0;

                    // Calculate totals
                    totalKasus += kasus;
                    totalPenduduk += penduduk;
                    if (status === 'tinggi') {
                        totalDesaRawan++;
                    }
                    totalDesa++;
                });

                // Set values to overview form
                $('input[name="total_kasus"]').val(totalKasus);
                $('input[name="total_penduduk"]').val(totalPenduduk);
                $('input[name="total_desa_rawan"]').val(totalDesaRawan);
                $('input[name="jumlah_desa"]').val(totalDesa);
                $('input[name="tahun"]').val(selectedYear);
            }

            // Form publish submission
            $("#form-publish").on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Success",
                            text: "Data Overview Berhasil Dipublikasikan",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan saat publikasi overview. Silakan coba lagi.",
                            icon: "error"
                        });
                    }
                });
            });
        });
    </script>
@endsection
