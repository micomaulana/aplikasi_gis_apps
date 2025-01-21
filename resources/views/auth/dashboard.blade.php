@extends('layouts.main')
@section('content')
    <style>
        .card-body div:nth-child(2) {
            font-size: 12px !important;
            font-weight: bold !important;
            margin: 0.2rem 0 !important;
        }
    </style>
    <?php
    $jumlah_kasus = '';
    if ($jumlah_kasus_perdesa != null) {
        $jumlah_kasus = $jumlah_kasus_perdesa->count_kasus;
    } else {
        $jumlah_kasus = 0;
    }
    
    ?>
    <div class="container-fluid">
        @if ((Auth::user()->hasRole('Kepala Puskes') || Auth::user()->hasRole('Admin')) && $jumlah_kasus >= 5)
            <div class="alert-box" id="alert-danger-custom">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-exclamation-circle alert-icon"></i>
                    <div>
                        <div class="alert-heading">Peringatan! Tindakan Segera Diperlukan</div>
                        <div>Jumlah kasus DBD di desa <span id="nama_desa">{{ $jumlah_kasus_perdesa->nama_desa }}</span>
                            telah mencapai
                            <span id="jumlah_kasus">{{ $jumlah_kasus_perdesa->count_kasus }}</span> kasus pada bulan
                            <span id="month">Januari 2024</span> mohon segera memproses pengajuan fogging ke kepala
                            puskesmas
                        </div>
                    </div>
                </div>

                <form action="{{ route('laporan_view') }}" method="get">
                    @unless (Auth::user()->hasRole('Kepala Puskes'))
                        <!-- Menyembunyikan tombol bagi Kepala Puskes -->
                        <button type="submit" class="alert-button">Buat laporan fogging</button>
                    @endunless
                </form>
            </div>
        @endif
    </div>

    <div class="container mt-4">

        @if (Auth::user()->hasRole('Kepala Puskes') || (Auth::user()->hasRole('Admin') && $jumlah_kasus_terkini >= 5))
            <div class="card p-3">
                <h5>Status terkini ({{ $currentYearMonth = \Carbon\Carbon::now()->format('F Y') }})</h5>
                <div class="d-flex justify-content-between">
                    <div class="status-card">
                        <h5>Jumlah kasus</h5>
                        <div class="value red" id="jumlah_pasien">{{ $jumlah_kasus_terkini }}</div>
                    </div>
                    <div class="status-card" id="status_card">
                        <h5>Status</h5>
                        <div class="value" id="status_data_pasien">Normal</div>
                    </div>
                    <div class="status-card">
                        <h5>Update terakhir</h5>
                        <div class="value blue">{{ $last_updated_times->updated_at ?? 'N\A' }}</div>
                        {{-- <div class="value blue">12/1/2024, 1:16:12 PM</div> --}}
                    </div>
                </div>
            </div>
        @endif
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
                            <!-- Replace the existing dropdown section with this -->
                            <div class="col-md-3">
                                <div class="dropdown mb-4">
                                    <select class="form-select" name="tahun" id="tahun">
                                        <option value="" selected>Pilih Tahun</option>
                                        @php
                                            // Ubah tahun mulai dari 2022
                                            $startYear = 2022;
                                            $currentYear = \Carbon\Carbon::now()->year;
                                        @endphp

                                        @for ($year = $startYear; $year <= $currentYear; $year++)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <!-- Statistics Cards -->
                            {{-- <div class="row" id="data_per_tahun">
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
                                </div> --}}
                        </div>

                        <!-- Traffic Overview Section -->
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                                            Sebaran Kasus per Desa
                                            <span>
                                                <iconify-icon icon="solar:question-circle-bold"
                                                    class="fs-7 d-flex text-muted" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-custom-class="tooltip-success"
                                                    data-bs-title="Distribution of cases by village"></iconify-icon>
                                            </span>
                                        </h5>
                                        <div id="cases-by-village"></div>
                                        <div class="mt-3 d-flex justify-content-center gap-4" id="legend-chart">
                                            <div class="d-flex align-items-center">
                                                <span class="me-2"
                                                    style="display:inline-block;width:10px;height:10px;background-color:#4bbf73;border-radius:2px;"></span>
                                                <span>Aman (0 kasus)</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="me-2"
                                                    style="display:inline-block;width:10px;height:10px;background-color:#f0ad4e;border-radius:2px;"></span>
                                                <span>Sedang (1-4 kasus)</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="me-2"
                                                    style="display:inline-block;width:10px;height:10px;background-color:#d9534f;border-radius:2px;"></span>
                                                <span>Parah (≥5 kasus)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- <div class="col-lg p-4 ms-3 me-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pasien</h5>
                <div class="table-responsive">
                    <table class="table text-nowrap align-middle mb-0">
                        <thead>
                            <tr class="border-2 border-bottom border-primary border-0">
                                <th scope="col" class="ps-0">Nama</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Tanggal Dibuat</th>
                                <th scope="col" class="text-center">Desa</th>
                                <th scope="col" class="text-center">Kab/Kota</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($pasiens as $pasien)
                                <tr>
                                    <th scope="row" class="ps-0 fw-medium">
                                        <span class="table-link1 text-truncate d-block">{{ $pasien->nama }}</span>
                                    </th>
                                    <td>
                                        <a href="javascript:void(0)"
                                            class="link-primary text-dark fw-medium d-block">{{ $pasien->desa->nama }}</a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            class="link-primary text-dark fw-medium d-block">{{ $pasien->created_at }}</a>
                                    </td>
                                    <td class="text-center fw-medium"></td>
                                    <td class="text-center fw-medium">Musi Banyuasin</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}

    <script>
        $(document).ready(function() {
            $('#status_card').hide();
            // $('#alert-danger-custom').hide();

            $.ajax({
                url: `/get_data_pasien_alert`,
                type: 'GET',
                success: function(response) {

                    if (response && response.data) {

                        let count = 0;
                        let desaNames = [];

                        let month = "";
                        $('#month').html(response.month);

                        // console.log("data:");
                        // console.log(response.jumlah_pasien);

                        // if (response.jumlah_pasien > 0) {
                        //     // count++;
                        //     // desaNames.push("suryo");
                        //     kasusHtml +=
                        //         `<span>${response.jumlah_pasien} kasus di desa ${desa.nama} dan </span>`;

                        // }
                        // data.forEach(function(desa) {
                        // });

                        // if (count > 0) {
                        //     $('#status_data_pasien').removeClass('text-success').addClass(
                        //         'text-danger');
                        //     $('#status_data_pasien').html("Perlu Tindakan");
                        //     $('#alert-danger-custom').show();

                        //     if (count === 1) {
                        //         $('#nama_desa').html(desaNames[0]);
                        //     } else {
                        //         let desaNamesString = desaNames.join(", ");
                        //         $('#nama_desa').html(desaNamesString);
                        //     }

                        //     // $('#jumlah_kasus').html(kasusHtml);
                        // } else {
                        //     $('#status_data_pasien').removeClass('text-danger').addClass(
                        //         'text-success');
                        //     $('#status_data_pasien').html("Normal");
                        //     $('#alert-danger-custom').hide();
                        // }
                    }
                }
            });

            function updateData() {
                const desaId = $('#karya_maju').val();
                const tahun = $('#tahun').val();
                let kasusHtml = "";
                // if (desaId === 'karya_maju') return; // Don't make request if default option is selected

                $.ajax({
                    url: `/get_data_pasien_by_desa/${desaId}`,
                    type: 'GET',
                    data: {
                        tahun: tahun
                    }, // Add year parameter
                    success: function(response) {
                        if (response && response.data) {
                            let data = response.data;
                            console.log(response);

                            $('#status_card').show();


                            $('#tahun_2022').text(data.jumlah_pasien_by_filter[0] || '0');
                            $('#tahun_2023').text(data.jumlah_pasien_by_filter[1] || '0');
                            $('#tahun_2024').text(data.jumlah_pasien_by_filter[2] || '0');
                            $("#jumlah_pasien").html(response.jumlah_pasien);
                            // kasusHtml +=
                            //     `<span>${response.jumlah_pasien} kasus di desa ${response.desa.nama} dan </span>`;
                            $('#jumlah_kasus').html(data.jumlah_pasien_by_filter[2]);
                            $('#nama_desa').html(response.desa.nama)
                            $('#data_per_tahun').css('display', 'flex');
                            // if (response.jumlah_pasien >= 5) {
                            //     $('#alert-danger-custom').show();

                            // }
                            if (response.jumlah_pasien >= 5) {
                                $('#status_data_pasien').removeClass('text-success').addClass(
                                    'text-danger');
                                $('#status_data_pasien').html("Perlu Tindakan");
                                $('#alert-danger-custom').show();

                            } else {
                                $('#status_data_pasien').removeClass('text-danger').addClass(
                                    'text-success');
                                $('#status_data_pasien').html("Normal");
                            }

                            // Update grafik
                            if (response.data_chart) {
                                let options = {
                                    series: [{
                                        name: "Jumlah Kasus",
                                        data: response.data_chart.values ||
                                        [] // Data dari server
                                    }],
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
                                        [] // Labels dari server
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
            }

            // Event listeners
            $('#karya_maju, #tahun').change(function() {
                updateData();
            });




            function updatePieChart() {
                const tahun = $('#tahun').val();

                $.ajax({
                    url: `/get_data_pasien_by_desa_pie`,
                    type: 'GET',
                    data: {
                        tahun: tahun
                    },
                    success: function(response) {
                        if (response && response.data_chart) {
                            // Generate colors based on values
                            const colors = response.data_chart.values.map(value => {
                                if (value === 0)
                                    return '#4bbf73'; // Hijau untuk kasus 0 (Aman)
                                if (value < 5)
                                    return '#f0ad4e'; // Kuning untuk kasus < 5 (Sedang)
                                return '#d9534f'; // Merah untuk kasus >= 5 (Parah)
                            });

                            let options = {
                                series: response.data_chart.values,
                                chart: {
                                    type: 'pie',
                                    height: 320,
                                    fontFamily: "inherit",
                                },
                                labels: response.data_chart.labels,
                                colors: colors,
                                legend: {
                                    position: 'bottom',
                                    horizontalAlign: 'center',
                                    fontSize: '14px',
                                    markers: {
                                        width: 10,
                                        height: 10,
                                        radius: 2
                                    },
                                    formatter: function(seriesName, opts) {
                                        const value = opts.w.globals.series[opts
                                            .seriesIndex];
                                        let status = '';
                                        if (value === 0) status = '(Aman)';
                                        else if (value < 5) status = '(Sedang)';
                                        else status = '(Parah)';
                                        return `${seriesName} - ${value} kasus ${status}`;
                                    }
                                },
                                plotOptions: {
                                    pie: {
                                        donut: {
                                            size: '0%'
                                        }
                                    }
                                },
                                tooltip: {
                                    y: {
                                        formatter: function(value) {
                                            let status = value === 0 ? 'Aman' :
                                                value < 5 ? 'Sedang' : 'Parah';
                                            let color = value === 0 ? '#4bbf73' :
                                                value < 5 ? '#f0ad4e' : '#d9534f';
                                            return `${value} kasus - Status: <span>${status}</span>`;
                                        }
                                    }
                                },
                                responsive: [{
                                    breakpoint: 480,
                                    options: {
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }]
                            };

                            if (window.casesChart) {
                                window.casesChart.destroy();
                            }

                            window.casesChart = new ApexCharts(
                                document.querySelector("#cases-by-village"),
                                options
                            );
                            window.casesChart.render();

                            // Add legend for status colors
                            //         let statusLegend = `
                        // `;

                            //         $('#cases-by-village').after(statusLegend);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error);
                    }
                });
            }

            // Event listener for year change only
            $('#tahun').change(function() {
                updatePieChart();
            });

            // Initial load
            updatePieChart();
        });
    </script>
@endsection
