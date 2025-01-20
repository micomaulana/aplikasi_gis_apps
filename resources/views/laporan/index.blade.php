@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="header d-flex align-items-center">
            <i class="fas fa-file-alt me-2"></i>
            <h1>Laporan</h1>
            <select class="form-select ms-auto" style="width: 100px;">
                <option>2024</option>
            </select>
        </div>

        <div class="form-section">
            <div class="card p-3">
                <h5>Form pengajuan</h5>
                <form action="{{ route('laporan-foggings.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="desa" class="form-label">Desa</label>
                        <select id="desa" class="form-select" name="id_desa">
                            <option selected>Pilih desa</option>
                            @foreach ($desas as $desa)
                                <option value="{{ $desa->id }}">{{ $desa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlahKasus" class="form-label">Jumlah kasus</label>
                        <input type="number" name="jumlah_kasus" id="jumlahKasus" class="form-control" value="">
                    </div>
                    <div class="mb-3">
                        <label for="tanggalPengajuan" class="form-label">Tanggal Pengajuan</label>
                        <input type="date" name="tanggal_pengajuan" id="tanggalPengajuan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name= "keterangan" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajukan ke Kepala Puskesmas</button>
                </form>
            </div>
        </div>

        <div class="status-section">
            <div class="card p-3">
                <h5>Status pengajuan fogging</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Desa</th>
                            <th>Kasus</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan_foggings as $laporan_fogging)
                            <tr>
                                <td>{{ $laporan_fogging->desa->nama }}</td>
                                <td>{{ $laporan_fogging->jumlah_kasus }}</td>
                                <td>{{ $laporan_fogging->tanggal_pengajuan }}</td>
                                <td>
                                    <span
                                        class="badge 
                                        {{ $laporan_fogging->status_pengajuan === 'disetujui'
                                            ? 'bg-success'
                                            : ($laporan_fogging->status_pengajuan === 'ditolak'
                                                ? 'bg-danger'
                                                : ($laporan_fogging->status_pengajuan === 'waiting'
                                                    ? 'bg-warning'
                                                    : 'bg-secondary')) }}">
                                        {{ $laporan_fogging->status_pengajuan }}
                                    </span>
                                </td>
                                <td>

                                    <button class="btn btn-outline-primary btn-sm lihat-preview"
                                        data-id="{{ $laporan_fogging->id }}">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm hide-preview">
                                        <i class="fas fa-eye"></i> hide
                                    </button>
                                    {{-- <div class="pdf-preview" style="display: none; margin-top: 10px;">
                                        <iframe src="/path/to/pdf/{{ $laporan_fogging->id }}" width="100%" height="200px" frameborder="0"></iframe>
                                    </div> --}}
                                    {{-- <button class="btn btn-outline-secondary btn-sm print-preview">
                                        <i class="fas fa-print"></i> Cetak
                                    </button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="preview-section" id="preview-section">
            <div class="card p-3">
                <h5>Preview laporan pengajuan fogging</h5>
                <div class="d-flex justify-content-end mb-2">
                    <button class="btn btn-outline-secondary btn-sm print-table" data-id="{{ $laporan_fogging->id }}">
                        <i class="fas fa-print"></i> Cetak
                    </button>
                    <button class="btn btn-outline-primary btn-sm" id="download-pdf"><i class="fas fa-file-pdf"></i> Unduh
                        pdf</button>
                </div>
                <div class="card-body">
                    <h6 class="text-center">Laporan pengajuan fogging</h6>
                    <p class="text-center">Nomor: PMK/FG/01/2024</p>
                    <input type="text" id="id_fogging" hidden>
                    <p>
                        Kepada Yth.<br>
                        Kepala Dinas Kesehatan Kabupaten Musi Banyuasin<br>
                        Di Tempat<br><br>
                        Dengan hormat,<br>
                        Bersama ini kami mengajukan permohonan fogging di wilayah berikut:<br><br>
                        Desa: <span id="desa_laporan">test</span><br>
                        Jumlah kasus: <span id="jumlah_kasus_laporan"></span><br>
                        Tanggal pengajuan: <span id="tanggal_pengajuan_laporan"></span><br><br>
                        Status: <span id="status_laporan"></span><br>
                        Tanggal Persetujuan: <span id="tanggal_disetujui_laporan"></span><br><br>
                        Demikian permohonan ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima
                        kasih.<br><br>
                        Hormat kami,<br>
                        Kepala Puskesmas Karya Maju
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#preview-section").hide();
            $(".hide-preview").hide();

            // Logika untuk select desa
            $('#desa').on('change', function() {
                var desaId = $(this).val(); // Ambil value dari select option
                console.log(desaId);

                if (desaId) {
                    $.ajax({
                        url: '/get-jumlah-pasien-perdesa/' +
                            desaId, // Endpoint untuk mengambil data
                        type: 'GET',
                        success: function(response) {
                            console.log(response);
                            $('#jumlahKasus').val(response.data);
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText); // Tangani error
                        }
                    });
                }
            });

            // Logika untuk tombol "Lihat"
            $('.lihat-preview').on('click', function() {
                console.log('preview click');
                $("#preview-section").show();
                $(".hide-preview").show();
                $(".lihat-preview").hide();
                let id_foggings = $(this).data('id');
                let url = "{{ route('laporan-foggings.show', ':id') }}".replace(':id', id_foggings);
                $.ajax({
                    url: url, // Endpoint untuk mengambil data
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        const tanggal_persetujuan = formatDate(response.data
                            .tanggal_persetujuan);
                        const tanggal_pengajuan_laporan = formatDate(response.data
                            .tanggal_pengajuan);
                        $('#desa_laporan').text(response.data.desa.nama);
                        $('#jumlah_kasus_laporan').text(response.data.jumlah_kasus);
                        $('#tanggal_pengajuan_laporan').text(tanggal_pengajuan_laporan);
                        $('#status_laporan').text(response.data.status_pengajuan);
                        $('#id_fogging').val(response.data.id);
                        if (response.data.tanggal_persetujuan == null) {
                            $('#tanggal_disetujui_laporan').text("Belum Disetujui");
                        } else {
                            $('#tanggal_disetujui_laporan').text(tanggal_persetujuan)

                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText); // Tangani error
                    }
                });
            });

            $('.hide-preview').on('click', function() {
                console.log('preview click');
                $("#preview-section").hide();
                $(".hide-preview").hide();
                $(".lihat-preview").show();
            });
            $('#download-pdf').on('click', function() {
                let id_fogging = $("#id_fogging").val();
                window.location.href = "/generate-pdf/" + id_fogging;
            });

            // Fungsi untuk format tanggal menjadi 'd m y'
            function formatDate(dateString) {
                if (!dateString) return ''; // Jika tidak ada tanggal
                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0'); // Menambahkan 0 di depan jika kurang dari 10
                const month = String(date.getMonth() + 1).padStart(2,
                    '0'); // Bulan dimulai dari 0, jadi kita tambahkan 1
                const year = date.getFullYear(); // Mendapatkan tahun

                return `${day} ${month} ${year}`;
            }

            $('.print-table').on('click', function() {
                const id = $(this).data('id');
                // Buka URL cetak dalam window baru
                window.open(`/print-laporan/${id}`, '_blank');
            });

            // Function to print preview section
            $('.print-preview').on('click', function() {
                const id = $('#id_fogging').val();
                window.open(`/print-laporan/${id}`, '_blank');
            });


        });
    </script>
@endsection
