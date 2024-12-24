@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <style>
            #map {
                height: 400px;
                width: 100%;
                margin-top: 20px;
                margin-bottom: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
        </style>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="container p-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Detail Lokasi Desa</h5>
                </div>
                <div class="card-body">
                    <form>
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" value="{{ $desa->nama }}"
                                name="nama" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                value="{{ $desa->longitude }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude"
                                value="{{ $desa->latitude }}" readonly>
                        </div>

                        <div id="map"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            if (document.getElementById('map')) {
                // Get coordinates from the input fields
                const latitude = parseFloat(document.getElementById('latitude').value);
                const longitude = parseFloat(document.getElementById('longitude').value);
                const locationName = document.getElementById('nama').value;

                // Initialize the map centered on the desa location
                const map = L.map('map').setView([latitude, longitude], 13);

                // Add OpenStreetMap tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Add marker for the desa location
                const marker = L.marker([latitude, longitude])
                    .addTo(map)
                    .bindPopup(locationName)
                    .openPopup();

                // Add circle to show approximate area
                L.circle([latitude, longitude], {
                    color: '#2196f3',
                    fillColor: '#2196f3',
                    fillOpacity: 0.15,
                    radius: 1000 // 1km radius
                }).addTo(map);
            }
        });
    </script>
@endsection
