@extends('Landing_page.layout')
@section('content')
    <div class="container-fluid mt-5">
        <div class="card custom-card shadow-card">
            <div class="card-header">
                Landing Page
            </div>
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
                            <a class="btn" href="#">
                                Baca Lebih Lanjut
                            </a>
                        </div>
                    </div>
                </div>
                <div class="chart-card card">
                    <h5>
                        Progress Kasus DBD 3 tahun terakhir
                    </h5>
                    <img alt="Line chart showing the progress of DBD cases over the last 3 years" height="300"
                        src="https://storage.googleapis.com/a1aa/image/4ex81er3Ehp3VE2A20e9spXAx6XG2uVWy6wqJyUDs5oee4XgC.jpg"
                        width="600" />
                    <p>
                        Data diambil dari arsip Puskesmas Karya Maju (2024).
                    </p>
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
                            <a class="btn" href="#">
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
                            <a class="btn" href="#">
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
                            <a class="btn" href="#">
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
@endsection
