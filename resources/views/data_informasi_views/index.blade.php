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
                                    <div class="text-primary">{{$totalkasus}}</div>
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
                                    <div class="status-tinggi-text">{{$jumlah_keseluruhan_desa_rawan}}</div>
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
                                    <div class="status-rendah-text">{{$jumlah_keseluruhan_penduduk_terdampak}}</div>
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
                                    <div class="status-sedang-text">{{$jumlah_desa_terdampak}}</div>
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
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Karya maju</td>
                    <td>8</td>
                    <td class="status-sedang-text">Sedang</td>
                    <td>4804</td>
                    <td>11 Jan 2024</td>
                    <td><a href="#">Detail</a></td>
                </tr>
                <tr>
                    <td>Tenggoro</td>
                    <td>3</td>
                    <td class="status-sedang-text">Sedang</td>
                    <td>1990</td>
                    <td>7 Jan 2024</td>
                    <td><a href="#">Detail</a></td>
                </tr>
                <tr>
                    <td>Tanjung Dalam</td>
                    <td>1</td>
                    <td class="status-rendah-text">Rendah</td>
                    <td>1143</td>
                    <td>-</td>
                    <td><a href="#">Detail</a></td>
                </tr>
                <tr>
                    <td>Dawas</td>
                    <td>0</td>
                    <td class="status-rendah-text">Rendah</td>
                    <td>4548</td>
                    <td>13 Jan 2024</td>
                    <td><a href="#">Detail</a></td>
                </tr>
                <tr>
                    <td>Sumber Agung</td>
                    <td>1</td>
                    <td class="status-rendah-text">Rendah</td>
                    <td>2588</td>
                    <td>11 Jan 2024</td>
                    <td><a href="#">Detail</a></td>
                </tr>
                <tr>
                    <td>Tegal Mulyo</td>
                    <td>1</td>
                    <td class="status-rendah-text">Rendah</td>
                    <td>2255</td>
                    <td>6 Jan 2024</td>
                    <td><a href="#">Detail</a></td>
                </tr>
                <tr>
                    <td>Mulyo Asih</td>
                    <td>16</td>
                    <td class="status-tinggi-text">Tinggi</td>
                    <td>2605</td>
                    <td>11 Jan 2024</td>
                    <td><a href="#">Detail</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            var currentYear = new Date().getFullYear(); // Mendapatkan tahun sekarang
            var startYear = 2000; // Tahun mulai
            var yearSelect = $('#yearSelect');
            for (var year = currentYear; year >= startYear; year--) {
                yearSelect.append(new Option(year, year));
            }
        });
    </script>
@endsection
