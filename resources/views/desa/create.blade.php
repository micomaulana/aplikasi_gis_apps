@extends('layouts.main')
@section('content')
<!-- Add Leaflet CSS -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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

                    <form action="{{ route('desas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Desa</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>

                        <div class="mb-3">
                            <label for="search" class="form-label">Cari Lokasi</label>
                            <div class="position-relative">
                                <input type="text" class="form-control search-input" id="search"
                                    placeholder="Masukkan nama kota atau tempat...">
                                <div id="searchResults" class="search-results shadow-sm"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" readonly required>
                            </div>
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" readonly required>
                            </div>
                        </div>

                        <div class="map-wrapper card mb-4">
                            <div id="map"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Reset any conflicting styles */
.map-wrapper {
    position: relative;
    padding: 0;
    margin: 0;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    overflow: hidden;
}

#map {
    width: 100%;
    height: 500px;
    z-index: 1;
}

/* Ensure map controls are visible */
.leaflet-control-container {
    z-index: 2;
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    z-index: 1050;
    display: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.search-result-item {
    padding: 0.75rem 1rem;
    cursor: pointer;
    border-bottom: 1px solid #dee2e6;
    transition: background-color 0.2s ease;
}

.search-result-item:last-child {
    border-bottom: none;
}

.search-result-item:hover {
    background-color: #f8f9fa;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait for DOM and all resources to load
    window.addEventListener('load', function() {
        const mapElement = document.getElementById('map');
        if (!mapElement) return;

        // Initialize map
        const map = L.map('map', {
            minZoom: 5,
            maxZoom: 18,
            zoomControl: true,
            attributionControl: true
        }).setView([-2.548926, 118.014863], 5);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(map);

        let currentMarker = null;

        function updateMarker(lat, lng, zoomLevel = 13) {
            if (currentMarker) {
                map.removeLayer(currentMarker);
            }

            currentMarker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            document.getElementById('latitude').value = Number(lat).toFixed(6);
            document.getElementById('longitude').value = Number(lng).toFixed(6);

            map.setView([lat, lng], zoomLevel, {
                animate: true,
                duration: 1
            });

            currentMarker.on('dragend', function(event) {
                const position = event.target.getLatLng();
                updateMarker(position.lat, position.lng, map.getZoom());
            });
        }

        const searchInput = document.getElementById('search');
        const searchResults = document.getElementById('searchResults');
        let debounceTimer;

        searchInput.addEventListener('input', function(e) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const searchTerm = e.target.value;
                if (searchTerm.length < 3) {
                    searchResults.style.display = 'none';
                    return;
                }

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchTerm)}&countrycodes=id&limit=5`)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';
                        searchResults.style.display = data.length ? 'block' : 'none';

                        data.forEach(result => {
                            const div = document.createElement('div');
                            div.className = 'search-result-item';
                            div.textContent = result.display_name;
                            div.addEventListener('click', () => {
                                const lat = parseFloat(result.lat);
                                const lon = parseFloat(result.lon);
                                updateMarker(lat, lon);
                                searchInput.value = result.display_name;
                                searchResults.style.display = 'none';
                            });
                            searchResults.appendChild(div);
                        });
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        searchResults.style.display = 'none';
                    });
            }, 300);
        });

        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            updateMarker(lat, lng);

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    searchInput.value = data.display_name;
                })
                .catch(error => {
                    console.error('Reverse geocoding error:', error);
                    searchInput.value = `${lat}, ${lng}`;
                });
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });

        // Force map to update its size
        setTimeout(() => {
            map.invalidateSize();
        }, 100);
    });
});
</script>
@endsection