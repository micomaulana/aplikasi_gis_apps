@extends('faq_masyarakat.layout')

@section('content')
    <div class="container-fluid mt-5">
        <!-- FAQ Header -->
        <div class="card custom-card shadow-card">
            <div class="card-header">
                FAQ
            </div>
        </div>

        <!-- FAQ Items -->
        <div class="faq-item">
            <h5>Apa itu penyakit DBD</h5>
            <p>
                DBD (Demam Berdarah Dengue) adalah penyakit yang disebabkan oleh virus dengue yang ditularkan
                melalui gigitan nyamuk Aedes aegypti. Gejala utama meliputi demam tinggi mendadak, sakit kepala
                berat, nyeri otot dan sendi, serta munculnya bintik merah pada kulit.
            </p>
        </div>

        <div class="faq-item">
            <h5>Bagaimana cara saya mencegah DBD</h5>
            <p>
                Pencegahan DBD dapat dilakukan dengan metode 3M Plus: Menguras bak mandi secara rutin,
                Menutup tempat penampungan air, Mengubur barang bekas yang dapat menampung air, ditambah
                dengan penggunaan lotion anti nyamuk dan pemasangan kawat kasa.
            </p>
        </div>

        <div class="faq-item">
            <h5>Kapan saya harus ke puskesmas</h5>
            <p>
                Segera ke Puskesmas jika mengalami gejala: demam tinggi lebih dari 3 hari, muntah terus
                menerus, nyeri perut hebat, pendarahan (mimisan/gusi), atau muncul bintik merah pada kulit.
            </p>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
            <h5>Belum menemukan jawaban?</h5>
            <p>Hubungi kami melalui:</p>
            <p>
                <i class="fas fa-phone"></i>
                Telepon: 082184911376
            </p>
            <p>
                <i class="fas fa-envelope"></i>
                Email: <a href="mailto:puskesmas-karyamaju.id">puskesmas-karyamaju.id</a>
            </p>
            <p>
                <i class="fas fa-map-marker-alt"></i>
                Alamat: Jalan Nusantara, desa Karya Maju
            </p>
        </div>
    </div>
@endsection
