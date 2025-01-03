<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Template</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome for icons (optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Page Layout for Printing */
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        .preview-section {
            margin-top: 20px;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: none;
            padding: 20px;
        }

        h5,
        h6 {
            font-size: 20px;
            font-weight: bold;
        }

        p {
            font-size: 14px;
            margin-bottom: 15px;
        }

        .text-center {
            text-align: center;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        /* Print Specific Styles */
        @media print {
            body {
                background-color: white;
                color: black;
            }

            .d-flex {
                display: none;
            }

            .card {
                border: none;
                box-shadow: none;
            }

            h5 {
                font-size: 22px;
            }

            h6 {
                font-size: 18px;
            }

            p {
                font-size: 16px;
                margin-bottom: 10px;
            }
        }

        /* Additional Styling */
        .card-body {
            padding: 15px;
        }

        .text-primary {
            color: #007bff;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .mt-2 {
            margin-top: 10px;
        }

        .custom-text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="preview-section" id="preview-section">
        <div class="container">
            <div class="card p-3">
                {{-- <h5>laporan pengajuan fogging untuk desa {{$data->desa->nama}}</h5> --}}
                <div class="card-body">
                    <h6 class="text-center">Laporan pengajuan fogging</h6>
                    <p class="text-center">Nomor: PMK/FG/01/2024</p>
                    <p>
                    <div class="row">
                        <div class="col-12">
                            Kepada Yth.<br>
                            Kepala Dinas Kesehatan Kabupaten Musi Banyuasin<br>
                            Di Tempat<br><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            Dengan hormat,<br>
                            Bersama ini kami mengajukan permohonan fogging di wilayah berikut:<br><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            Desa:<span id="desa_laporan">{{ $data->desa->nama }}</span>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-4">
                            Jumlah kasus: <span id="jumlah_kasus_laporan">{{ $data->jumlah_kasus }}</span>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-4">
                            Tanggal pengajuan: <span id="tanggal_pengajuan_laporan">
                                {{ date('d m Y', strtotime($data->tanggal_pengajuan)) }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            Status: <span id="status_laporan">{{ $data->status_pengajuan }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            Tanggal Persetujuan: <span id="tanggal_disetujui_laporan">
                                {{ $data->tanggal_persetujuan ? date('d m Y', strtotime($data->tanggal_persetujuan)) : 'Belum Disetujui' }}
                            </span>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            Demikian permohonan ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima
                            kasih.<br><br><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 custom-text-right">
                            Hormat kami,<br><br><br><br>
                            Kepala Puskesmas Karya Maju
                        </div>
                    </div>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and Popper (necessary for dropdowns, tooltips, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
