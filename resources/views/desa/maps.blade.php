@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <style>
            #map {
                height: 500px;
                width: 100%;
                max-height: 80vh;
                z-index: 0;
            }

            .sidebar {
                position: fixed;
                z-index: 999;
                width: 300px;
                height: 100%;
                background-color: white;
                overflow-y: auto;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            }

            @media screen and (max-width: 768px) {
                #map {
                    height: 300px;
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
            const markerIcons = {
                default: L.icon({
                    iconUrl: '/marker/default.png',
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

            function getMarkerIcon(data) {
                const patientCount = data.length;
                if (patientCount >= 5) return markerIcons.high;
                if (patientCount > 2) return markerIcons.medium;
                return markerIcons.low;
            }

            function createPatientPopupContent(pasien) {
                return `
                    <b>Nama Pasien:</b> ${pasien.nama}<br>
                    <b>Alamat:</b> ${pasien.alamat}<br>
                    <b>Usia:</b> ${pasien.usia}<br>
                    <b>Jenis Kelamin:</b> ${pasien.jenis_kelamin}<br>
                    <b>Nama Desa:</b> ${pasien.desa.nama}
                `;
            }

            function createDesaPopupContent(desa) {
                return `<b>Nama Desa:</b> ${desa.nama}<br>` +
                    `<b>Luas Wilayah:</b> ${desa.luas} KM²<br>` +
                    `<b>Kepadatan:</b> ${desa.kepadatan} KM²`;
            }

            async function loadDesaData(desaId, markers) {
                try {
                    const response = await $.ajax({
                        url: '/getPasien/' + desaId,
                        method: 'GET'
                    });

                    const marker = markers[desaId];
                    if (marker) {
                        marker.setIcon(getMarkerIcon(response.data));
                    }

                    return response.data;
                } catch (error) {
                    console.error('Error fetching data for desa ' + desaId + ':', error);
                    return [];
                }
            }

            async function updateTable(pasienData) {
                $('#pasienTable tbody').empty();
                pasienData.forEach((pasien, index) => {
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
            }

            async function initializeMap() {
                const desasData = @json($desas);
                console.log('Data Desa:', desasData);

                const defaultDesa = desasData[0];
                const map = L.map('map').setView(
                    [parseFloat(defaultDesa.latitude), parseFloat(defaultDesa.longitude)],
                    12
                );

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                for (const desa of desasData) {
                    try {
                        // Ambil data pasien terlebih dahulu
                        const response = await fetch(`/getPasien/${desa.id}`);
                        const pasienData = await response.json();
                        console.log(`Data pasien untuk ${desa.nama}:`, pasienData);

                        const jumlahKasus = pasienData.data.length;

                        // Tentukan warna berdasarkan jumlah kasus
                        let circleColor;
                        if (jumlahKasus >= 5) {
                            circleColor = '#FF0000'; // Merah untuk risiko tinggi
                        } else if (jumlahKasus >= 3) {
                            circleColor = '#FFD700'; // Kuning untuk risiko sedang
                        } else {
                            circleColor = '#008000'; // Hijau untuk risiko rendah
                        }

                        const lat = parseFloat(desa.latitude);
                        const lng = parseFloat(desa.longitude);

                        // Tambahkan marker
                        const marker = L.marker([lat, lng], {
                            icon: markerIcons.default
                        }).addTo(map);

                        // Tambahkan circle dengan warna yang sesuai
                        const circle = L.circle([lat, lng], {
                            color: circleColor,
                            fillColor: circleColor,
                            fillOpacity: 0.2,
                            radius: 1000 // 1km radius
                        }).addTo(map);

                        // Popup untuk marker
                        const popupContent = `
                <strong>Desa ${desa.nama}</strong><br>
                Luas Wilayah: ${desa.luas} KM²<br>
                Kepadatan: ${desa.kepadatan} orang/KM²<br>
                Jumlah Kasus: ${jumlahKasus}<br>
                Status: ${
                    jumlahKasus >= 5 ? 'Risiko Tinggi' :
                    jumlahKasus >= 3 ? 'Risiko Sedang' :
                    'Risiko Rendah'
                }
            `;
                        marker.bindPopup(popupContent);
                        circle.bindPopup(popupContent);

                        // Event handler untuk marker
                        marker.on('click', function() {
                            // Update tabel
                            updateTable(pasienData.data);
                            $('#pasienTable').show();

                            // Pindahkan view ke lokasi yang diklik
                            map.setView([lat, lng], 13);
                        });

                        // Set marker icon sesuai jumlah kasus
                        if (jumlahKasus >= 5) {
                            marker.setIcon(markerIcons.high);
                        } else if (jumlahKasus >= 3) {
                            marker.setIcon(markerIcons.medium);
                        } else {
                            marker.setIcon(markerIcons.low);
                        }

                    } catch (error) {
                        console.error(`Error processing desa ${desa.nama}:`, error);
                    }
                }
            }


            // Fungsi untuk mengupdate tabel
            function updateTable(pasienData) {
                const tbody = $('#pasienTable tbody');
                tbody.empty();

                pasienData.forEach((pasien, index) => {
                    const row = `
            <tr>
                <td>${index + 1}</td>
                <td>${pasien.nama || '-'}</td>
                <td>${pasien.alamat || '-'}</td>
                <td>${pasien.usia || '-'}</td>
                <td>${pasien.jenis_kelamin || '-'}</td>
                <td>${pasien.desa?.nama || '-'}</td>
            </tr>
        `;
                    tbody.append(row);
                });
            }

            // Initialize map when document is ready
            $(document).ready(function() {
                console.log('Initializing map...');
                $('#pasienTable').hide();
                initializeMap().catch(error => {
                    console.error('Error initializing map:', error);
                });
            });
        </script>
    </div>
@endsection
