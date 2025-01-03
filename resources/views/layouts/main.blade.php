<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SeoDash Free Bootstrap Admin Template by Adminmart</title>
    <link rel="shortcut icon" type="image/png" href="/Seodash-assets/images/logos/seodashlogo.png" />
    <link rel="stylesheet" href="/Seodash-assets/css/styles.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- 3. Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Add Leaflet Search CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.0/leaflet-search.min.css" />

    <!-- Add Leaflet Search JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.0/leaflet-search.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    {{-- datatables --}}

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script src="/Seodash-assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Seodash-assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="/Seodash-assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="/Seodash-assets/js/sidebarmenu.js"></script>
    <script src="/Seodash-assets/js/app.min.js"></script>
    <script src="/Seodash-assets/js/dashboard.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <style>
        .alert-box {
            border: 1px solid #007bff;
            border-radius: 5px;
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
            background-color: white;
            box-shadow: 5px 5px 10px gray;

        }

        .alert-icon {
            color: #dc3545;
            font-size: 24px;
            margin-right: 10px;
        }

        .alert-heading {
            font-weight: bold;
        }

        .alert-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 14px;
        }

        .status-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .status-card h5 {
            margin: 0;
        }

        .status-card .value {
            font-size: 24px;
            font-weight: bold;
        }

        .status-card .value.red {
            color: red;
        }

        .status-card .value.blue {
            color: blue;
        }

        <style>.stats-container {
            padding: 20px;
        }

        .dropdown-toggle {
            background-color: #f3f0ff;
            color: #000;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background-color: #fff2f2;
            border-radius: 10px;
            padding: 15px;
            margin: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .mosquito-icon {
            width: 24px;
            height: 24px;
            margin-right: 8px;
            fill: #000;
        }

        .stat-number {
            color: #ff0000;
            font-size: 24px;
            font-weight: bold;
            margin-right: 8px;
        }

        .stat-text {
            font-size: 14px;
            color: #333;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #E0E7FF;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        .form-section,
        .status-section,
        .preview-section {
            margin-bottom: 20px;
        }

        .form-section .card,
        .status-section .card,
        .preview-section .card {
            border-radius: 10px;
        }

        .status-section table {
            width: 100%;
        }

        .status-section th,
        .status-section td {
            text-align: center;
            vertical-align: middle;
        }

        .status-section th {
            background-color: #E0E7FF;
        }

        .status-section .btn {
            margin: 0 5px;
        }

        .preview-section .card-body {
            background-color: #F3F4F6;
        }

        #data_per_tahun {
            display: none;
        }

        .custom-card {
            border-radius: 10px;
            background-color: #f9f9f9;
            /* Warna latar belakang kartu */
        }

        .shadow-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .custom-card-header {
            font-weight: bold;
            padding: 10px 15px;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }

        .custom-card-body {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            /* Tambahkan padding di dalam body */
        }

        .custom-card-body div {
            width: 22%;
            /* Pastikan semua kotak memiliki lebar seragam */
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Bayangan untuk setiap kotak */
            padding: 15px;
            text-align: center;
        }

        .custom-card-body h6 {
            font-size: 14px;
            color: #555;
        }

        .custom-card-body h3 {
            font-size: 24px;
            color: #333;
            font-weight: bold;
        }

        /* General Styling */
        .container {
            max-width: 900px;
        }

        /* Header Styling */
        .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        /* Status Badge */
        .badge.bg-success {
            background-color: #28a745;
            color: #fff;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 5px;
        }

        /* Buttons */
        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
            margin-top: 5px;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }

        /* Table */
        .table-bordered {
            margin-bottom: 0;
        }

        .table-light th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        /* Custom Spacing */
        .me-2 {
            margin-right: 10px;
        }

        .hidden {
            display: none;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            margin: 50px auto;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #4a4aff;
            border: none;
        }

        #button-setuju {
            background: #70FE85;
            color: black;
            font-weight: bold;
        }

        #button-tolak {
            background: #EF0B0B;
            color: black;
            font-weight: bold;
        }


        .card {
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            font-weight: normal;
            font-size: 0.8rem;
            padding: 0.3rem;
            border-bottom: none;
            background: transparent;
        }

        .card-body {
            font-size: 0.8rem;
            padding: 0.5rem;
        }

        /* Untuk angka-angka yang ditampilkan */
        .card-body div:nth-child(2) {
            font-size: 1.1rem;
            font-weight: bold;
            margin: 0.2rem 0;
        }

        /* Untuk teks di bawah angka */
        .card-body div:nth-child(3) {
            font-size: 0.7rem;
            color: #666;
            margin-top: 0.1rem;
        }

        .status-tinggi {
            background-color: #fff5f5;
            border: 1px solid #ffe6e6;
        }

        .status-rendah {
            background-color: #f5fff5;
            border: 1px solid #e6ffe6;
        }

        .status-sedang {
            background-color: #fffff5;
            border: 1px solid #ffffe6;
        }

        .status-tinggi-text {
            color: #dc3545;
        }

        .status-rendah-text {
            color: #28a745;
        }

        .status-sedang-text {
            color: #ffc107;
        }

        .table th,
        .table td {
            vertical-align: middle;
            font-size: 0.85rem;
            padding: 0.5rem;
        }

        /* Container untuk card */
        .card .card-body {
            min-height: 80px;
        }

        /* Tambahan untuk mengatur jarak antar card */
        .col-3 {
            padding: 0.3rem;
        }

        /* Optional: atur max-width untuk container card */
        .row {
            max-width: 1200px;
            margin-left: 0;
        }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('layouts.sidebar')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            @include('layouts.topheader')
            <!--  Header Start -->
            <!--  Header End -->
            @yield('content')
        </div>
    </div>

    {{-- <script src="/Seodash-assets/libs/jquery/dist/jquery.min.js"></script> --}}

</body>

</html>
