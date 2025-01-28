@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <style>
            #map {
                height: 500px;
                width: 100%;
                max-height: 80vh;
                z-index: 0;
                /* Limit the height for small screens */
            }

            .sidebar {
                position: fixed;
                z-index: 999;
                /* Beri nilai lebih besar untuk sidebar */
                width: 300px;
                /* Atur lebar sidebar sesuai kebutuhan */
                height: 100%;
                background-color: white;
                /* Warna background untuk sidebar */
                overflow-y: auto;
                /* Tambahkan jika sidebar memiliki konten panjang */
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            }

            @media screen and (max-width: 768px) {
                #map {
                    height: 300px;
                    /* Adjust height for smaller screens */
                }
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }

            th,
            td {
                padding: 8px;
                text-align: left;
            }
        </style>

        <div id="map"></div>

        <table id="pasienTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Alamat</th>
                    <th>Usia</th>
                    <th>Jenis Kelamin</th>
                    <th>Nama Desa</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be dynamically inserted here -->
            </tbody>
        </table>

        <script>
            // Define marker icons configuration
            const markerIcons = {
                default: L.icon({
                    iconUrl: '/marker/default.png', // Tambahkan icon default untuk desa
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32]
                }),
                high: L.icon({
                    iconUrl: '/marker/red.png',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32]
                }),
                medium: L.icon({
                    iconUrl: '/marker/orange.png',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32]
                }),
                low: L.icon({
                    iconUrl: '/marker/green.png',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32]
                })
            };

            // Helper function to get marker icon based on count
            function getMarkerIcon(data) {
                const patientCount = data.length;
                if (patientCount >= 5) return markerIcons.high;
                if (patientCount > 2) return markerIcons.medium;
                return markerIcons.low;
            }

            // Helper function to create popup content for patients
            function createPatientPopupContent(pasien) {
                return `
                    <b>Nama Pasien:</b> ${pasien.nama}<br>
                    <b>Alamat:</b> ${pasien.alamat}<br>
                    <b>Usia:</b> ${pasien.usia}<br>
                    <b>Jenis Kelamin:</b> ${pasien.jenis_kelamin}<br>
                    <b>Nama Desa:</b> ${pasien.desa.nama}
                `;
            }

            // Helper function to create popup content for desa
            function createDesaPopupContent(desa) {
                return `<b>Nama Desa:</b> ${desa.nama}<br>` + `<b>luas wilayah</b>:${desa.luas} KM²<br>` +
                    `<b>Kepadatan</b>:${desa.kepadatan} KM²`;
            }

            $(document).ready(function() {
                console.log("load jq");
                $('#pasienTable').hide();

                if (!navigator.geolocation) {
                    alert("Browser Anda tidak mendukung Geolocation API.");
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        initializeMap(position);
                    },
                    function(error) {
                        console.error("Geolocation gagal:", error);
                        alert("Gagal mendapatkan lokasi Anda. Pastikan fitur lokasi diaktifkan.");
                    }
                );
            });

            function initializeMap(position) {
                let desa_location = @json($desa_loc);
                console.log(desa_location);

                const userLatitude = desa_location.latitude;
                const userLongitude = desa_location.longitude;

                const map = L.map('map').setView([userLatitude, userLongitude], 10);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                const desasData = @json($desas);
                let offset = 0;
                const markers = {}; // Object untuk menyimpan referensi marker

                // Add markers for each desa
                desasData.forEach(function(desa) {
                    const baseLatitude = parseFloat(desa.latitude);
                    const baseLongitude = parseFloat(desa.longitude);

                    const latitude = baseLatitude + offset * 0.0001;
                    const longitude = baseLongitude + offset * 0.0001;

                    const marker = L.marker([latitude, longitude], {
                        icon: markerIcons.default
                    }).addTo(map);

                    marker.bindPopup(createDesaPopupContent(desa));
                    markers[desa.id] = marker; // Simpan referensi marker
                    offset += 1;

                    marker.on('click', function() {
                        handleDesaMarkerClick(desa.id, map, markers);
                    });
                });
            }

            function handleDesaMarkerClick(desaId, map, markers) {
                console.log("ID Desa yang dipilih: " + desaId);
                $('#pasienTable').show();

                $.ajax({
                    url: '/getPasien/' + desaId,
                    method: 'GET',
                    success: function(response) {

                        $('#pasienTable tbody').empty();

                        // Update marker yang diklik
                        const clickedMarker = markers[desaId];
                        const markerIcon = getMarkerIcon(response.data);

                        if (clickedMarker) {
                            clickedMarker.setIcon(markerIcon);
                        }

                        // Update tabel
                        response.data.forEach((pasien, index) => {
                            const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${pasien.nama}</td>
                        <td>${pasien.alamat}</td>
                        <td>${pasien.usia}</td>
                        <td>${pasien.jenis_kelamin}</td>
                        <td>${pasien.desa.nama}</td>
                    </tr>
                `;
                            $('#pasienTable tbody').append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                        alert('Gagal mengambil data pasien untuk desa ' + desaId);
                    }
                });
            }
        </script>
    </div>
@endsection