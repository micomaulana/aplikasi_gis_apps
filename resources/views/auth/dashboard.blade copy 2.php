@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <div class="alert-box">
            <div class="d-flex align-items-center mb-2">
                <i class="fas fa-exclamation-circle alert-icon"></i>
                <div>
                    <div class="alert-heading">Peringatan! Tindakan Segera Diperlukan</div>
                    <div>Jumlah kasus DBD di desa Karya Maju telah mencapai 6 kasus pada bulan januari 2024
                        mohon segera memproses pengajuan fogging ke kepala puskesmas</div>
                </div>
            </div>
            <form action="{{ route('laporan_view') }}" method="get">
                <button type="submit" class="alert-button">Buat laporan fogging</button>
            </form>
        </div>
        <div class="container mt-4">
            <div class="card p-3">
                <h5>Status terkini (Januari 2024)</h5>
                <div class="d-flex justify-content-between">
                    <div class="status-card">
                        <h5>Jumlah kasus</h5>
                        <div class="value red" id="jumlah_pasien">{{ $jumlah_pasien }}</div>
                    </div>
                    <div class="status-card">
                        <h5>Status</h5>
                        <div class="value" id="status_data_pasien">Normal</div>
                    </div>
                    <div class="status-card">
                        <h5>Update terakhir</h5>
                        <div class="value blue">{{ $last_updated_times->updated_at }}</div>
                        {{-- <div class="value blue">12/1/2024, 1:16:12 PM</div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Patient Stats Section -->
                            <div class="stats-container">
                                <h5 class="mb-3">Grafik pasien</h5>

                                <!-- Dropdown Button -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="dropdown mb-4">
                                            <select class="form-select dropdown-toggle d-flex align-items-center"
                                                name="karya_maju" id="karya_maju">
                                                <option value="karya_maju" selected>Pilih Desa</option>
                                                @foreach ($desa_list as $desa)
                                                    <option value="{{ $desa->id }}">{{ $desa->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Statistics Cards -->
                                <div class="row">
                                    <!-- 2022 Stats -->
                                    <div class="col-md-4">
                                        <div class="stat-card">
                                            <div class="d-flex align-items-center">
                                                <svg class="mosquito-icon" viewBox="0 0 24 24">
                                                    <path
                                                        d="M16.5,12.5c0,0.9-0.7,1.6-1.6,1.6s-1.6-0.7-1.6-1.6c0-0.9,0.7-1.6,1.6-1.6S16.5,11.6,16.5,12.5z M19.5,12.5 c0,2.5-2,4.5-4.5,4.5s-4.5-2-4.5-4.5s2-4.5,4.5-4.5S19.5,10,19.5,12.5z M8.5,12.5c0,0.9-0.7,1.6-1.6,1.6s-1.6-0.7-1.6-1.6 c0-0.9,0.7-1.6,1.6-1.6S8.5,11.6,8.5,12.5z" />
                                                </svg>
                                                <span class="stat-number" id="tahun_2022">8</span>
                                                <span class="stat-text">kasus di tahun 2022</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2023 Stats -->
                                    <div class="col-md-4">
                                        <div class="stat-card">
                                            <div class="d-flex align-items-center">
                                                <svg class="mosquito-icon" viewBox="0 0 24 24">
                                                    <path
                                                        d="M16.5,12.5c0,0.9-0.7,1.6-1.6,1.6s-1.6-0.7-1.6-1.6c0-0.9,0.7-1.6,1.6-1.6S16.5,11.6,16.5,12.5z M19.5,12.5 c0,2.5-2,4.5-4.5,4.5s-4.5-2-4.5-4.5s2-4.5,4.5-4.5S19.5,10,19.5,12.5z M8.5,12.5c0,0.9-0.7,1.6-1.6,1.6s-1.6-0.7-1.6-1.6 c0-0.9,0.7-1.6,1.6-1.6S8.5,11.6,8.5,12.5z" />
                                                </svg>
                                                <span class="stat-number" id="tahun_2023">6</span>
                                                <span class="stat-text">kasus di tahun 2023</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2024 Stats -->
                                    <div class="col-md-4">
                                        <div class="stat-card">
                                            <div class="d-flex align-items-center">
                                                <svg class="mosquito-icon" viewBox="0 0 24 24">
                                                    <path
                                                        d="M16.5,12.5c0,0.9-0.7,1.6-1.6,1.6s-1.6-0.7-1.6-1.6c0-0.9,0.7-1.6,1.6-1.6S16.5,11.6,16.5,12.5z M19.5,12.5 c0,2.5-2,4.5-4.5,4.5s-4.5-2-4.5-4.5s2-4.5,4.5-4.5S19.5,10,19.5,12.5z M8.5,12.5c0,0.9-0.7,1.6-1.6,1.6s-1.6-0.7-1.6-1.6 c0-0.9,0.7-1.6,1.6-1.6S8.5,11.6,8.5,12.5z" />
                                                </svg>
                                                <span class="stat-number" id="tahun_2024">5</span>
                                                <span class="stat-text">kasus di tahun 2024</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Traffic Overview Section -->
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                                                Traffic Overview
                                                <span>
                                                    <iconify-icon icon="solar:question-circle-bold"
                                                        class="fs-7 d-flex text-muted" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-custom-class="tooltip-success"
                                                        data-bs-title="Traffic Overview"></iconify-icon>
                                                </span>
                                            </h5>
                                            <div id="traffic-overview">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg p-4 ms-3 me-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pasien</h5>
                <div class="table-responsive">
                    <table class="table text-nowrap align-middle mb-0">
                        <thead>
                            <tr class="border-2 border-bottom border-primary border-0">
                                <th scope="col" class="ps-0">Nama</th>
                                <th scope="col">Alamat</th>
                                <th scope="col" class="text-center">Desa</th>
                                <th scope="col" class="text-center">Kab/Kota</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr>
                                <th scope="row" class="ps-0 fw-medium">
                                    <span class="table-link1 text-truncate d-block">Mico</span>
                                </th>
                                <td>
                                    <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">Karya
                                        Maju
                                        Blok A</a>
                                </td>
                                <td class="text-center fw-medium">Karya Maju</td>
                                <td class="text-center fw-medium">Musi Banyuasin</td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-0 fw-medium">
                                    <span class="table-link1 text-truncate d-block">Andi</span>
                                </th>
                                <td>
                                    <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">Karya
                                        Maju
                                        Blok B</a>
                                </td>
                                <td class="text-center fw-medium">Karya Maju</td>
                                <td class="text-center fw-medium">Musi Banyuasin</td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-0 fw-medium">
                                    <span class="table-link1 text-truncate d-block">Budi</span>
                                </th>
                                <td>
                                    <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">Karya
                                        Maju Blok C</a>
                                </td>
                                <td class="text-center fw-medium">Karya Maju</td>
                                <td class="text-center fw-medium">Musi Banyuasin</td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-0 fw-medium">
                                    <span class="table-link1 text-truncate d-block">Citra</span>
                                </th>
                                <td>
                                    <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">Karya
                                        Maju Blok D</a>
                                </td>
                                <td class="text-center fw-medium">Karya Maju</td>
                                <td class="text-center fw-medium">Musi Banyuasin</td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-0 fw-medium border-0">
                                    <span class="table-link1 text-truncate d-block">Deni</span>
                                </th>
                                <td class="border-0">
                                    <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">Karya
                                        Maju Blok E</a>
                                </td>
                                <td class="text-center fw-medium border-0">Karya Maju</td>
                                <td class="text-center fw-medium border-0">Musi Banyuasin</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#status_data_pasien').addClass('text-success');
            $('#status_data_pasien').html("Normal");

            $('#karya_maju').change(function() {
                const desaId = $(this).val();
                console.log("Data select option changed");
                console.log("Selected Desa ID:", desaId);

                $.ajax({
                    url: `/get_data_pasien_by_desa/${desaId}`, // URL sesuai dengan route
                    type: 'GET', // HTTP method
                    success: function(response) {
                        // Pastikan response memiliki data yang diharapkan
                        if (response && response.data) {
                            let data = response.data;

                            // Update nilai span
                            $('#tahun_2022').text(data.jumlah_pasien_2022 || '0');
                            $('#tahun_2023').text(data.jumlah_pasien_2023 || '0');
                            $('#tahun_2024').text(data.jumlah_pasien_2024 || '0');
                            $("#jumlah_pasien").html(response.jumlah_pasien);

                            if (response.jumlah_pasien >= 5) {
                                $('#status_data_pasien').addClass('text-danger');
                                $('#status_data_pasien').html("Perlu Tindakan");
                            } else {
                                $('#status_data_pasien').removeClass('text-danger');
                                $('#status_data_pasien').addClass('text-success');
                                $('#status_data_pasien').html("Normal");
                            }


                            // Update grafik
                            if (response.data_chart) {
                                let options = {
                                    series: [{
                                        name: "New Users",
                                        data: response.data_chart.values ||
                                    [], // Data dari server
                                    }, ],
                                    chart: {
                                        toolbar: {
                                            show: false
                                        },
                                        type: "bar",
                                        fontFamily: "inherit",
                                        foreColor: "#adb0bb",
                                        height: 320,
                                        stacked: false,
                                    },
                                    colors: ["#6ea8fe"],
                                    plotOptions: {
                                        bar: {
                                            borderRadius: 4,
                                            columnWidth: '40%',
                                        },
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    legend: {
                                        show: false
                                    },
                                    stroke: {
                                        width: 2,
                                        curve: "smooth",
                                        dashArray: [8, 0],
                                    },
                                    grid: {
                                        borderColor: "rgba(0,0,0,0.1)",
                                        strokeDashArray: 3,
                                        xaxis: {
                                            lines: {
                                                show: false
                                            }
                                        },
                                    },
                                    xaxis: {
                                        axisBorder: {
                                            show: false
                                        },
                                        axisTicks: {
                                            show: false
                                        },
                                        categories: response.data_chart.labels ||
                                    [], // Labels dari server
                                    },
                                    yaxis: {
                                        tickAmount: 4
                                    },
                                    markers: {
                                        strokeColor: "#6ea8fe",
                                        strokeWidth: 2,
                                    },
                                    tooltip: {
                                        theme: "dark"
                                    },
                                };

                                // Hapus grafik lama sebelum render baru
                                if (window.trafficChart) {
                                    window.trafficChart.destroy();
                                }

                                // Render grafik baru
                                window.trafficChart = new ApexCharts(
                                    document.querySelector("#traffic-overview"),
                                    options
                                );
                                window.trafficChart.render();
                            } else {
                                console.warn("data_chart tidak ditemukan dalam response");
                            }
                        } else {
                            console.warn("Response tidak valid:", response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error);
                        alert('Terjadi kesalahan: ' + xhr.statusText);
                    }
                });
            });
        });
    </script>
@endsection
