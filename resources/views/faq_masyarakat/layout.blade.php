<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SeoDash Free Bootstrap Admin Template by Adminmart</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="/Seodash-assets/images/logos/seodashlogo.png" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/Seodash-assets/css/styles.css" />

    <!-- Third Party CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.0/leaflet-search.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

    <!-- Custom Styles -->
    <style>
        /* Alert Box Styles */
        .alert-box {
            border: 1px solid #007bff;
            border-radius: 5px;
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
            background-color: white;
            box-shadow: 5px 5px 10px gray;
        }

        /* Status Card Styles */
        .status-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: #2c3e50;
            height: 100vh;
            position: fixed;
            width: 60px;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }

        /* Content Area Styles */
        .content {
            margin-left: 80px;
            padding: 20px;
        }

        /* FAQ Styles */
        .faq-item {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Contact Info Styles */
        .contact-info {
            background-color: #e8eaf6;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content Wrapper -->
        <div class="body-wrapper">
            @include('layouts.topheader')
            @yield('content')
        </div>
    </div>

    <!-- Core Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="/Seodash-assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Third Party Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.0/leaflet-search.min.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <!-- Custom Scripts -->
    <script src="/Seodash-assets/js/sidebarmenu.js"></script>
    <script src="/Seodash-assets/js/app.min.js"></script>
    <script src="/Seodash-assets/js/dashboard.js"></script>
</body>

</html>
