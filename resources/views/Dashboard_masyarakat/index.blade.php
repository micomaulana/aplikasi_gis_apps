@extends('Dashboard_masyarakat.layout')
@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="nav flex-column">
                    <a class="nav-link" href="#">
                        <i class="fas fa-plus">
                        </i>
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-th-large">
                        </i>
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-chart-bar">
                        </i>
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-file-alt">
                        </i>
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-question-circle">
                        </i>
                    </a>
                </div>
            </nav>
            {{-- <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4 content"> --}}
            <div class="container">
                <div class="dashboard-header">
                    <h1>
                        <i class="fas fa-tachometer-alt">
                        </i>
                        Profil
                    </h1>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Profil Puskesmas Karya Maju
                        </h5>
                        <div class="d-flex justify-content-between">
                            <img alt="Puskesmas Karya Maju building" class="img-fluid" height="100"
                                src="/Seodash-assets/images/Puskesmas/kegiatan.jpg"
                                width="150" />
                            <img alt="Healthcare workers assisting a patient" class="img-fluid" height="100"
                                src="/Seodash-assets/images/Puskesmas/kegiatan2.jpg"
                                width="150" />
                            <img alt="Community health event" class="img-fluid" height="100"
                                src="/Seodash-assets/images/Puskesmas/kegiatan3.jpg"
                                width="150" />
                        </div>
                    </div>
                </div>
                <div class="info-box">
                    <h5>
                        Tentang Puskesmas Karya Maju
                    </h5>
                    <p>
                        Puskesmas Karya Maju yang berlokasi di Jalan Nusantara, Desa Karya Maju, Kecamatan Keluang,
                        Kabupaten Musi Banyuasin, Sumatra Selatan, berdiri sejak Mei 1985 untuk memberikan layanan kesehatan
                        rawat jalan kepada masyarakat. Seiring dengan meningkatnya kebutuhan pelayanan kesehatan, Puskesmas
                        ini mulai menyediakan layanan rawat inap pada bulan mei tahun 1996.
                    </p>
                </div>
                <div class="stats-box">
                    <div class="stat">
                        <h6>
                            Tahun Berdiri
                        </h6>
                        <p>
                            1985
                        </p>
                    </div>
                    <div class="stat">
                        <h6>
                            Wilayah layanan
                        </h6>
                        <p>
                            8 Desa
                        </p>
                    </div>
                    <div class="stat">
                        <h6>
                            layanan
                        </h6>
                        <p>
                            Rawat Jalan &amp; Inap
                        </p>
                    </div>
                </div>
            </div>
            {{-- </main> --}}
        </div>
    </div>
@endsection
