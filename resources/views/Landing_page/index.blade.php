@extends('Landing_page.layout')
@section('content')
    <div class="container-fluid mt-5">
        <div class="card custom-card shadow-card">
            <div class="content">
                <div class="header">
                    <img alt="Puskesmas Karya Maju building with a signboard" height="300"
                        src="https://storage.googleapis.com/a1aa/image/e31qa6U4LDQKTK5oKa5PTyiTrSwTkkvOa3MoLUmaeHvtHfFoA.jpg"
                        width="1200" />
                </div>
                <div class="info-card card">
                    <div class="row">
                        <div class="col-md-3">
                            <img alt="A mosquito" height="100"
                                src="https://storage.googleapis.com/a1aa/image/eFfTrfhZ7iMHxo381AjqcdafbmkHA3jiFE0nlLH25SKFf4XgC.jpg"
                                width="100" />
                        </div>
                        <div class="col-md-9">
                            <h2>
                                DEMAM BERDARAH DENGUE
                            </h2>
                            <p>
                                adalah penyakit yang ditularkan oleh gigitan nyamuk bernama Aedes aegypti. Penyakit ini
                                masih menjadi salah satu isu kesehatan masyarakat di Indonesia, dan angka penyebarannya di
                                Indonesia termasuk yang tertinggi di antara negara-negara Asia Tenggara.
                            </p>
                            <a class="btn" href="https://www.alodokter.com/demam-berdarah">
                                Baca Lebih Lanjut
                            </a>
                        </div>
                    </div>
                </div>
                <div class="chart-card card">
                    <h5>Progress Kasus DBD 3 tahun terakhir</h5>
                    <div id="dbd-cases-chart" style="height: 320px;"></div>
                    <p>Data diambil dari arsip Puskesmas Karya Maju (2024).</p>
                </div>
                <div class="important-info row">
                    <div class="col-md-4">
                        <div class="card">
                            <h5>
                                Gejala DBD
                            </h5>
                            <p>
                                Demam tinggi mendadak
                                <br />
                                Sakit kepala berat
                                <br />
                                Nyeri otot dan sendi
                                <br />
                                Muncul bintik merah
                            </p>
                            <a class="btn" href="https://www.alodokter.com/demam-berdarah">
                                Baca Lebih Lanjut
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h5>
                                Pencegahan 3M Plus
                            </h5>
                            <p>
                                Menguras bak mandi
                                <br />
                                Menutup tempat air
                                <br />
                                Mengubur barang bekas
                                <br />
                                Pakai lotion anti nyamuk
                            </p>
                            <a class="btn" href="https://www.alodokter.com/demam-berdarah">
                                Baca Lebih Lanjut
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h5>
                                Kapan ke Puskesmas
                            </h5>
                            <p>
                                Demam &gt;3 hari
                                <br />
                                Muntah terus menerus
                                <br />
                                Mimisan/gusi berdarah
                                <br />
                                Lemas dan mengantuk
                            </p>
                            <a class="btn" href="https://www.alodokter.com/demam-berdarah">
                                Baca Lebih Lanjut
                            </a>
                        </div>
                    </div>
                </div>
                <div class="footer row">
                    <div class="col-md-6">
                        <p>
                            Puskesmas Karya Maju
                            <br />
                            Jalan nusantara desa Karya Maju
                            <br />
                            082184911376
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            Jam operasional
                            <br />
                            Senin - Jumat: 08.00 - 16.00
                            <br />
                            Sabtu: 08.00 - 12.00
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.0/apexcharts.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var chartOptions = {
                series: [{
                    name: "Total Tindakan",
                    data: @json($series), // Data Y-axis (jumlah pasien)
                }],
                chart: {
                    type: "bar", // Ubah tipe chart menjadi bar
                    height: 320,
                },
                xaxis: {
                    categories: @json($categories), // Data X-axis (tahun)
                    title: {
                        text: 'Tahun', // Label untuk sumbu X
                    },
                },
                colors: ["#00E396"], // Warna bar
                plotOptions: {
                    bar: {
                        borderRadius: 4, // Sudut bar yang lebih lembut
                        columnWidth: '50%', // Lebar kolom
                    }
                },
                tooltip: {
                    theme: "dark",
                },
            };

            var chart = new ApexCharts(
                document.querySelector("#dbd-cases-chart"), // ID elemen
                chartOptions
            );
            chart.render();
        });
    </script>
@endsection
