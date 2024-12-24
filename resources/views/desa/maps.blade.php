@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>

    <div id="map"></div>
    <script>
        $(document).ready(function() {
            console.log("load jq");
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Dapatkan latitude dan longitude pengguna
                        const userLatitude = position.coords.latitude;
                        const userLongitude = position.coords.longitude;

                        // Pastikan elemen #map sudah ada di HTML
                        const map = L.map('map').setView([userLatitude, userLongitude], 10); // Lokasi default

                        // Tambahkan tile layer dari OpenStreetMap
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(map);

                        // Data JSON yang Anda miliki
                        const pasienData = @json($desas);

                        // Offset kecil untuk menggeser marker
                        let offset = 0;

                        // Iterasi melalui setiap data pasien dan tambahkan marker ke peta
                        pasienData.forEach(function(pasien) {
                            const baseLatitude = parseFloat(pasien.latitude);
                            const baseLongitude = parseFloat(pasien.longitude);

                            // Tambahkan offset untuk menggeser posisi marker
                            const latitude = baseLatitude + offset * 0.0001; // Geser sedikit latitude
                            const longitude = baseLongitude + offset *
                            0.0001; // Geser sedikit longitude

                            // Tambahkan marker ke peta
                            const marker = L.marker([latitude, longitude]).addTo(map);

                            // Bind popup dengan informasi pasien
                            marker.bindPopup(
                                `<b>Nama Pasien:</b> ${pasien.nama_pasien}<br>
                                <b>Alamat:</b> ${pasien.alamat}<br>
                                <b>Usia:</b> ${pasien.usia}<br>
                                <b>Jenis Kelamin:</b> ${pasien.jenis_kelamin}<br>
                                <b>Nama Desa:</b> ${pasien.nama_desa}`
                            );

                            // Tambah offset untuk marker berikutnya
                            offset += 1;
                        });


                    },
                    function(error) {
                        // Tangani kesalahan jika geolocation gagal
                        console.error("Geolocation gagal:", error);
                        alert("Gagal mendapatkan lokasi Anda. Pastikan fitur lokasi diaktifkan.");
                    }
                );
            } else {
                alert("Browser Anda tidak mendukung Geolocation API.");
            }
        });
    </script>
@endsection
