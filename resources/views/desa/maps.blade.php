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

            .legend {
                padding: 10px;
                background: white;
                border-radius: 5px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            }

            .legend i {
                width: 18px;
                height: 18px;
                float: left;
                margin-right: 8px;
                opacity: 0.7;
            }

            .legend .legend-item {
                margin-bottom: 5px;
                clear: both;
            }

            .info-box {
                padding: 10px;
                background: white;
                border-radius: 5px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                margin-bottom: 10px;
            }

            .status-tinggi {
                background-color: #ffebee;
            }

            .status-sedang {
                background-color: #fff3e0;
            }

            .status-rendah {
                background-color: #e8f5e9;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            table,
            th,
            td {
                border: 1px solid #ddd;
            }

            th,
            td {
                padding: 12px;
                text-align: left;
            }

            th {
                background-color: #f5f5f5;
            }

            .circle-icon {
                display: inline-block;
                width: 12px;
                height: 12px;
                border-radius: 50%;
                margin-right: 5px;
            }


            .leaflet-popup-content {
                max-width: 250px;
                font-size: 12px;
                margin: 8px;
            }

            .leaflet-popup-content h5 {
                font-size: 14px;
                margin: 0 0 8px 0;
            }

            .leaflet-popup-content table {
                margin: 0;
            }

            .leaflet-popup-content td {
                padding: 2px 4px;
                font-size: 11px;
            }

            .popup-content small {
                display: block;
                margin-top: 5px;
                font-size: 10px;
                text-align: center;
            }
        </style>

        <div class="info-box">
            <h4>Peta Sebaran Kasus DBD</h4>
            <p>Incident Rate (IR) = (Jumlah Kasus / Jumlah Penduduk) × 100.000</p>
        </div>

        <div id="map"></div>

        <table id="pasienTable" class="mt-4" style="display: none;">
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

            function calculateIncidentRate(jumlahKasus, jumlahPenduduk) {
                if (!jumlahPenduduk || jumlahPenduduk === 0) return 0;
                if (!jumlahKasus || jumlahKasus === 0) return 0;

                const ir = (jumlahKasus / jumlahPenduduk) * 100000;
                console.log(`IR Calculation: (${jumlahKasus}/${jumlahPenduduk}) * 100000 = ${ir}`);
                return ir;
            }

            function getRiskStatus(incidentRate) {
                if (incidentRate > 75) {
                    return {
                        text: 'Risiko Sangat Tinggi',
                        color: '#FF0000', // Red
                        icon: markerIcons.high,
                        description: 'IR > 75 per 100.000 penduduk'
                    };
                } else if (incidentRate >= 55) {
                    return {
                        text: 'Risiko Tinggi',
                        color: '#FF4500', // Orange Red
                        icon: markerIcons.medium,
                        description: 'IR 55-75 per 100.000 penduduk'
                    };
                } else if (incidentRate >= 35) {
                    return {
                        text: 'Risiko Sedang',
                        color: '#FFD700', // Gold
                        icon: markerIcons.medium,
                        description: 'IR 35-55 per 100.000 penduduk'
                    };
                } else {
                    return {
                        text: 'Risiko Rendah',
                        color: '#008000', // Green
                        icon: markerIcons.low,
                        description: 'IR < 35 per 100.000 penduduk'
                    };
                }
            }

            function createLegend(map) {
                const legend = L.control({
                    position: 'bottomright'
                });

                legend.onAdd = function(map) {
                    const div = L.DomUtil.create('div', 'legend');
                    div.innerHTML = '<h4>Status Risiko DBD</h4>';

                    // Add legend items
                    const statuses = [{
                            ir: 75,
                            text: 'Risiko Sangat Tinggi',
                            color: '#FF0000',
                            desc: 'IR > 75'
                        },
                        {
                            ir: 55,
                            text: 'Risiko Tinggi',
                            color: '#FF4500',
                            desc: 'IR 55-75'
                        },
                        {
                            ir: 35,
                            text: 'Risiko Sedang',
                            color: '#FFD700',
                            desc: 'IR 35-55'
                        },
                        {
                            ir: 0,
                            text: 'Risiko Rendah',
                            color: '#008000',
                            desc: 'IR < 35'
                        }
                    ];

                    statuses.forEach(status => {
                        div.innerHTML += `
                <div class="legend-item">
                    <i style="background: ${status.color}"></i>
                    <span>${status.text}<br>
                    <small>(${status.desc})</small></span>
                </div>
            `;
                    });

                    return div;
                };

                legend.addTo(map);
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

                // Add legend to map
                createLegend(map);

                for (const desa of desasData) {
                    try {
                        // Fetch both patient and statistics data
                        const [responsePasien, responseStatistik] = await Promise.all([
                            fetch(`/getPasien/${desa.id}`),
                            fetch(`/getStatistik/${desa.id}`)
                        ]);

                        const pasienData = await responsePasien.json();
                        const statistikData = await responseStatistik.json();

                        if (!statistikData.data || !statistikData.data.jumlah_penduduk) {
                            console.warn(`Data penduduk tidak tersedia untuk desa ${desa.nama}`);
                            continue;
                        }

                        const jumlahKasus = pasienData.data.length;
                        const jumlahPenduduk = statistikData.data.jumlah_penduduk;
                        const incidentRate = calculateIncidentRate(jumlahKasus, jumlahPenduduk);
                        const status = getRiskStatus(incidentRate);

                        const lat = parseFloat(desa.latitude);
                        const lng = parseFloat(desa.longitude);

                        // Add marker
                        const marker = L.marker([lat, lng], {
                            icon: status.icon
                        }).addTo(map);

                        // Add circle
                        const circle = L.circle([lat, lng], {
                            color: status.color,
                            fillColor: status.color,
                            fillOpacity: 0.2,
                            radius: 1000
                        }).addTo(map);

                        // Create popup content
                        const popupContent = `
                            <div class="popup-content">
                                <h5>${desa.nama}</h5>
                                <table>
                                    <tr>
                                        <td>Luas wilayah</td>
                                        <td>: ${desa.luas} KM²</td>
                                    </tr>
                                    <tr>
                                        <td>Kepadatan penduduk</td>
                                        <td>: ${desa.kepadatan}/KM²</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah kasus</td>
                                        <td>: ${jumlahKasus}</td>
                                    </tr>
                                    <tr>
                                        <td>Total penduduk terdampak</td>
                                        <td>: ${jumlahPenduduk.toLocaleString()}</td>
                                    </tr>
                                    <tr>
                                        <td>Incident rate</td>
                                        <td>: ${incidentRate.toFixed(2)}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>: <span style="color:${status.color}">${status.text}</span></td>
                                    </tr>
                                </table>
                            </div>
                        `;

                        marker.bindPopup(popupContent);
                        circle.bindPopup(popupContent);

                        // Marker click event
                        marker.on('click', function() {
                            updateTable(pasienData.data);
                            $('#pasienTable').show();
                            map.setView([lat, lng], 13);
                        });

                    } catch (error) {
                        console.error(`Error processing desa ${desa.nama}:`, error);
                    }
                }
            }

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

            $(document).ready(function() {
                initializeMap().catch(error => {
                    console.error('Error initializing map:', error);
                });
            });
        </script>
    </div>
@endsection
