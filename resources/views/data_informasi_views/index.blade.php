@extends('layouts.main')
@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex align-items-center mb-3">
            <i class="fas fa-info-circle fa-lg me-2"></i>
            <h2 class="m-0" href="{{ route('data_informasi_views') }}">Data dan informasi</h2>
        </div>
        <div class="mb-3">
            <select class="form-select" aria-label="Select year" id="yearSelect">
            </select>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header">Σ</div>
                                <div class="card-body">
                                    <div>Total kasus</div>
                                    <div class="text-primary" id="total_kasus">{{ $totalkasus }}</div>
                                    <div>Seluruh wilayah</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card status-tinggi">
                            <div class="card-body">
                                <div class="card-header">⚠️</div>
                                <div class="card-body">
                                    <div>Desa rawan</div>
                                    <div class="status-tinggi-text" id="jumlah_keseluruhan_desa_rawan">
                                        {{ $jumlah_keseluruhan_desa_rawan }}</div>
                                    <div>Status tinggi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card status-rendah">
                            <div class="card-body">
                                <div class="card-header">👥</div>
                                <div class="card-body">
                                    <div>Total penduduk Terdampak</div>
                                    <div class="status-rendah-text" id="jumlah_keseluruhan_penduduk_terdampak">
                                        {{ $jumlah_keseluruhan_penduduk_terdampak }}</div>
                                    <div>Jiwa</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card status-sedang">
                            <div class="card-body">
                                <div class="card-header">🏠</div>
                                <div class="card-body">
                                    <div>Jumlah desa</div>
                                    <div class="status-sedang-text" id="jumlah_desa_terdampak">{{ $jumlah_desa_terdampak }}
                                    </div>
                                    <div>Wilayah</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h3>Data per desa</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Desa</th>
                    <th>Kasus</th>
                    <th>Status</th>
                    <th>Penduduk</th>
                    <th>Fogging terakhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statistik as $stat)
                    <tr>
                        <td>{{ $stat->desa->nama }}</td>
                        <td>{{ $stat->jumlah_kasus }}</td>
                        {{-- <td class="@class([
                            'status-tinggi-text' => strtolower($stat->status) == 'tinggi',
                            'status-sedang-text' => strtolower($stat->status) == 'sedang',
                            'status-rendah-text' => strtolower($stat->status) == 'rendah',
                        ])"> --}}

                        @if ($stat->status == 'tinggi')
                            <td class="text-danger">{{ $stat->status }}</td>
                        @elseif($stat->status == 'rendah')
                            <td class="text-success">{{ $stat->status }}</td>
                        @elseif($stat->status == 'sedang')
                            <td class="text-warning">{{ $stat->status }}</td>
                        @endif
                        <td>{{ $stat->jumlah_penduduk }}</td>
                        <td>{{ $stat->tanggal_fogging }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#yearSelect').change(function() {
                var selectedValue = $(this).val();
                $.ajax({
                    url: '/get-data-by-year/' +
                        selectedValue, // The route where you want to send the GET request
                    type: 'GET',
                    success: function(response) {
                        // Handle success
                        $('#total_kasus').text(response.data.total_kasus);
                        $('#jumlah_keseluruhan_desa_rawan').text(response.data
                            .jumlah_keseluruhan_desa_rawan);
                        $('#jumlah_keseluruhan_penduduk_terdampak').text(response.data
                            .jumlah_keseluruhan_penduduk_terdampak);
                        $('#jumlah_desa_terdampak').text(response.data.jumlah_desa_terdampak);

                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.log(error);
                    }
                });

                $.ajax({
                    url: '/get-data-statistik-by-year/' + selectedValue, // Endpoint
                    type: 'GET',
                    success: function(response) {
                        // Pastikan response.data adalah array
                        const statistikData = response.data;

                        // Bersihkan tabel sebelum menambahkan data baru
                        const tbody = $('table.table-bordered tbody');
                        tbody.empty();

                        // Iterasi setiap item dalam array data
                        statistikData.forEach(stat => {
                            const statusClass = stat.status.toLowerCase() === 'tinggi' ?
                                'text-danger' :
                                stat.status.toLowerCase() === 'rendah' ?
                                'text-success' :
                                stat.status.toLowerCase() === 'sedang' ?
                                'text-warning' : '';

                            const row = `
                <tr>
                    <td>${stat.desa.nama}</td>
                    <td>${stat.jumlah_kasus}</td>
                    <td class="${statusClass}">${stat.status}</td>
                    <td>${stat.jumlah_penduduk}</td>
                    <td>${stat.tanggal_fogging ?? '-'}</td>
                </tr>
            `;
                            tbody.append(row); // Tambahkan row ke tabel
                        });

                        console.log(response); // Debugging, pastikan data benar
                    },
                    error: function(xhr, status, error) {
                        console.log(error); // Debugging error
                    }
                });

            });

            var currentYear = new Date().getFullYear(); // Mendapatkan tahun sekarang
            var startYear = 2000; // Tahun mulai
            var yearSelect = $('#yearSelect');
            for (var year = currentYear; year >= startYear; year--) {
                yearSelect.append(new Option(year, year));
            }
        });
    </script>
@endsection
