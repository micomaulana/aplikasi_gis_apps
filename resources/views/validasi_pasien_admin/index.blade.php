@extends('layouts.main')
@section('content')
    <div class="container-fluid mt-5">
        <div class="card custom-card shadow-card">
            <div class="card-header">
                Validasi laporan kasus dbd
            </div>
            <div class="card-body custom-card-body">
                <div>
                    <h6>Total laporan</h6>
                    <h3>{{ $jumlah_laporan }}</h3>
                </div>
                <div>
                    <h6>Menunggu Validasi</h6>
                    <h3>{{ $jumlah_laporan_menunggu_validasi }}</h3>
                </div>
                <div>
                    <h6>Terkonfirmasi</h6>
                    <h3>{{ $jumlah_laporan_terkonfirmasi }}</h3>
                </div>
                <div>
                    <h6>Ditolak</h6>
                    <h3>{{ $jumlah_laporan_rejected }}</h3>
                </div>
            </div>
        </div>

        <h5 class="mt-4">Daftar Laporan</h5>
        <table class="table table-bordered mt-2 custom-table">
            <thead class="table-light">
                <tr>
                    <th>No. tiket</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupedData as $idPasien => $laporanList)
                    <tr>
                        <!-- Menampilkan data pertama saja untuk no_tiket, status, dan tanggal -->
                        <td>{{ $laporanList[0]['no_tiket'] }}</td>
                        <td>{{ $laporanList[0]['tanggal'] }}</td>
                        <td>{{ $laporanList[0]['pasien']->nama ?? 'N/A' }}</td>
                        <td>{{ $laporanList[0]['pasien']->alamat ?? 'N/A' }}</td>
                        <td class="custom-status">{{ $laporanList[0]['status'] }}</td>
                        <td>
                            @if (!Auth::user()->hasRole('Lab'))
                                <!-- Tombol Lihat -->
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#lihatModal"
                                    data-id="{{ $idPasien }}"
                                    data-nama="{{ $laporanList[0]['pasien']->nama ?? 'N/A' }}"
                                    data-usia="{{ $laporanList[0]['pasien']->usia ?? 'N/A' }}"
                                    data-alamat="{{ $laporanList[0]['pasien']->alamat ?? 'N/A' }}"
                                    data-file_lab="{{ $laporanList[0]['file_hasil_lab'] }}"
                                    data-gejala="{{ htmlspecialchars(json_encode($laporanList->pluck('gejala')), ENT_QUOTES, 'UTF-8') }}"
                                    data-gejala_lain="{{ $laporanList[0]['gejala_lain'] }}"
                                    data-created_at="{{ htmlspecialchars(json_encode($laporanList->pluck('created_at')), ENT_QUOTES, 'UTF-8') }}">
                                    <i class="fas fa-eye"></i> Lihat
                                </button>

                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    data-id="{{ $idPasien }}" data-laporan-id="{{ $laporanList->first()['id'] }}"
                                    data-status="{{ $laporanList->first()['status'] }}" data-dokter="Dr. Budi">
                                    <i class="fas fa-check"></i> Setuju
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#tolakModal"
                                    data-id="{{ $idPasien }}">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                                <button class="btn btn-info btn-sm btnLihatPasien" data-bs-toggle="modal"
                                    data-bs-target="#detailPasienModal" data-id="{{ $idPasien }}">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </button>
                                <button class="btn btn-success btn-sm btnValidasiLab" data-bs-toggle="modal"
                                    data-bs-target="#validasiModal" data-id="{{ $idPasien }}">
                                    <i class="bi bi-eye"></i> validasi modal
                                </button>
                            @else
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#hasilLabModal" data-id="{{ $idPasien }}">
                                    <i class="fas fa-flask"></i> Hasil Lab
                                </button>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Lihat -->
    <div class="modal fade" id="lihatModal" tabindex="-1" aria-labelledby="lihatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lihatModalLabel">Detail Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="lihatNama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="lihatNama" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="lihatUsia" class="form-label">Usia</label>
                        <input type="text" class="form-control" id="lihatUsia" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="lihatAlamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="lihatAlamat" rows="2" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="lihatGejala" class="form-label">Gejala</label>
                        <div id="lihatGejala" rows="3" readonly></div>
                    </div>
                    <div class="mb-3">
                        <label for="lihatGejalaLain" class="form-label">Gejala Lain</label>
                        <input class="form-control" id="lihatGejalaLain" rows="3" readonly></input>
                    </div>
                    <div class="mb-3">
                        <label for="lihatHasilLab" class="form-label">Hasil Laboratorium</label>
                        <div id="hasil-lab-container">
                            <a href="#" id="lihatHasilLab" target="_blank" class="form-control-link"
                                style="display: none;">Unduh Hasil Lab</a>
                            <p class="text-muted hasil-lab-empty" style="display: none;">Hasil lab belum diunggah</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- detail pasien --}}
    <div class="modal fade" id="detailPasienModal" tabindex="-1" aria-labelledby="detailPasienModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailPasienModalLabel">Detail Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- NIK -->
                    <div class="mb-3">
                        <label for="lihatdetailnik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="lihatdetailnik" readonly>
                    </div>

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="lihatdetailnama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="lihatdetailnama" readonly>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-3">
                        <label for="lihatJenisKelamin" class="form-label">Jenis Kelamin</label>
                        <input type="text" class="form-control" id="lihatJenisKelamin" readonly>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="mb-3">
                        <label for="lihatTempatLahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="lihatTempatLahir" readonly>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="mb-3">
                        <label for="lihatTanggalLahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="lihatTanggalLahir" readonly>
                    </div>

                    <!-- Usia -->
                    <div class="mb-3">
                        <label for="lihatdetailusia" class="form-label">Usia</label>
                        <input type="text" class="form-control" id="lihatdetailusia" readonly>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="lihatdetailalamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="lihatdetailalamat" rows="2" readonly></textarea>
                    </div>

                    <!-- Nama Desa -->
                    <div class="mb-3">
                        <label for="lihatNamaDesa" class="form-label">Nama Desa</label>
                        <input type="text" class="form-control" id="lihatNamaDesa" readonly>
                    </div>

                    <!-- Provinsi -->
                    <div class="mb-3">
                        <label for="lihatProvinsi" class="form-label">Provinsi</label>
                        <input type="text" class="form-control" id="lihatProvinsi" readonly>
                    </div>

                    <!-- Kabupaten/Kota -->
                    <div class="mb-3">
                        <label for="lihatKabKota" class="form-label">Kabupaten/Kota</label>
                        <input type="text" class="form-control" id="lihatKabKota" readonly>
                    </div>

                    <!-- No HP -->
                    <div class="mb-3">
                        <label for="lihatNoHp" class="form-label">No. HP</label>
                        <input type="text" class="form-control" id="lihatNoHp" readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal update Lab -->
    <div class="modal fade" id="hasilLabModal" tabindex="-1" aria-labelledby="hasilLabModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hasilLabModalLabel">Hasil Laboratorium</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadHasilLabForm" action="{{ route('update_by_lab') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="text" id="pasienIdHasilLab" name="id">

                        <div class="mb-3">
                            <label for="fileHasilLab" class="form-label">Unggah Hasil Laboratorium</label>
                            <input type="file" class="form-control" id="fileHasilLab" name="file_hasil_lab"
                                accept=".jpg,.jpeg,.png,.gif" required>
                            <small class="text-muted">Format yang diizinkan: JPG, JPEG, PNG, GIF. Ukuran maksimal:
                                2MB</small>
                        </div>

                        <div class="mb-3">
                            <label for="statusLab" class="form-label">Status</label>
                            <select class="form-select" id="statusLab" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="dbd">Positif DBD</option>
                                <option value="suspect">Suspect DBD</option>
                                <option value="bukan">Bukan DBD</option>
                            </select>
                        </div>

                        <div id="currentHasilLab" class="mb-3" style="display: none;">
                            <h6>Hasil Lab Saat Ini:</h6>
                            <div id="hasilLabPreview"></div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="btnSubmitHasilLab">Simpan</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal validasi Lab -->
    <div class="modal fade" id="validasiModal" tabindex="-1" aria-labelledby="hasilLabModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hasilLabModalLabel">Hasil Laboratorium</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="currentHasilLab" class="mb-3" style="display: none;">
                        <h6>Hasil Lab Saat Ini:</h6>
                        <img id="hasilLabPreview" src="#" alt="Preview Hasil Lab"
                            style="max-width: 100%; height: auto;" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitHasilLab">Simpan</button>
                </div>
            </div>
        </div>
    </div>


    {{-- modal form --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Verifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-container">
                        <!-- Form to submit data -->
                        <form id="LaporanForm" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" id="id_laporan_dbd" hidden>
                                <label for="statusKasus" class="form-label">Status Kasus</label>
                                <select class="form-select" id="statusKasus" name="status" required>
                                    <option value="dbd" {{ old('status_kasus') == 'dbd' ? 'selected' : '' }}>Positif
                                        DBD
                                    </option>
                                    <option value="suspect" {{ old('status_kasus') == 'suspect' ? 'selected' : '' }}>
                                        Suspect
                                        DBD</option>
                                    <option value="bukan" {{ old('status_kasus') == 'bukan' ? 'selected' : '' }}>Bukan
                                        DBD
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jadwalKontrol" class="form-label">Jadwal kontrol</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="id_lapora_kasus"
                                        name="tanggal_control" required>
                                    <input type="time" class="form-control" id="jadwalWaktu" name="waktu_control"
                                        required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="hariOtomatis" class="form-label">Hari Kontrol</label>
                                <input type="text" class="form-control" id="hariOtomatis" name="hari_otomatis"
                                    readonly>
                            </div>


                            <div class="mb-3">
                                <label for="dokterPJ" class="form-label">Dokter PJ</label>
                                <select class="form-select" id="dokterPJ" name="id_dokter" required>
                                    <option selected disabled>Pilih Dokter</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                {{-- <label for="catatanMedis" class="form-label">Catatan Medis</label>
                                <textarea class="form-control" id="catatanMedis" name="catatan_medis" rows="3"
                                    placeholder="Tambahkan catatan medis..." required>{{ old('catatan_medis') }}</textarea>
                            </div> --}}
                                <button type="submit" class="btn btn-primary">Terima Laporan</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tolak -->
    <div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tolakModalLabel">Konfirmasi Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak laporan ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmTolakBtn">Tolak Laporan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function formatTimestamp(timestamp) {
                // Membuat objek Date dari timestamp
                var date = new Date(timestamp);

                // Ekstraksi hari, bulan, dan tahun
                var day = date.getDate(); // Mendapatkan tanggal
                var month = date.getMonth() + 1; // Mendapatkan bulan (ditambah 1 karena index bulan dimulai dari 0)
                var year = date.getFullYear(); // Mendapatkan tahun

                // Menggabungkan dalam format d-M-Y
                return `${day}-${month}-${year}`;
            }
            // Set the id for the rejection modal
            $(document).on('click', '[data-bs-target="#tolakModal"]', function() {
                var id = $(this).data('id');
                $('#confirmTolakBtn').data('id', id);
            });

            // Handle rejection confirmation
            $('#confirmTolakBtn').on('click', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/laporan-tolak/' + id,
                    method: 'PUT',
                    data: {
                        _token: $('input[name="_token"]').val(),
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Laporan telah ditolak.",
                            icon: "success"
                        }).then(() => location.reload());
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat menolak laporan.",
                            icon: "error"
                        });
                    }
                });
            });

            // Event handler untuk perubahan tanggal dan waktu kontrol
            // Script untuk menampilkan hari otomatis
            $('#id_lapora_kasus').on('change', function() {
                var selectedDate = $(this).val();

                if (selectedDate) {
                    // Konversi tanggal ke hari
                    var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    var date = new Date(selectedDate);
                    var hari = days[date.getDay()];

                    // Tampilkan hari di input readonly
                    $('#hariOtomatis').val(hari);
                }
            });

            // Script untuk memuat daftar dokter yang tersedia
            $('#id_lapora_kasus, #jadwalWaktu').on('change', function() {
                var selectedDate = $('#id_lapora_kasus').val();
                var selectedTime = $('#jadwalWaktu').val();

                if (selectedDate && selectedTime) {
                    // Konversi tanggal ke hari
                    var days = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
                    var date = new Date(selectedDate);
                    var hari = days[date.getDay()];

                    // Ajax request untuk mendapatkan dokter yang tersedia
                    $.ajax({
                        url: '/get-dokter-schedule',
                        method: 'GET',
                        data: {
                            hari: hari,
                            jam: selectedTime
                        },
                        success: function(response) {
                            // Update dropdown dokter
                            var dokterSelect = $('#dokterPJ');
                            dokterSelect.empty();
                            dokterSelect.append(
                                '<option selected disabled>Pilih Dokter</option>');

                            if (response.length > 0) {
                                response.forEach(function(dokter) {
                                    dokterSelect.append(
                                        $('<option></option>')
                                        .attr('value', dokter.id)
                                        .text(dokter.nama + ' (' + dokter
                                            .jam_mulai + ' - ' + dokter
                                            .jam_selesai + ')')
                                    );
                                });
                            } else {
                                dokterSelect.append(
                                    $('<option disabled></option>')
                                    .text('Tidak ada dokter yang tersedia pada waktu ini')
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            Swal.fire({
                                title: "Error!",
                                text: "Gagal memuat data dokter.",
                                icon: "error"
                            });
                        }
                    });
                }
            });


            // Tangkap event sebelum modal ditampilkan
            $(document).on('click', '[data-bs-target="#exampleModal"]', function() {
                var laporanId = $(this).data('laporan-id'); // Get the specific report ID
                var status = $(this).data('status');
                var dokter = $(this).data('dokter');

                $('#statusKasus').val(status);
                $('#dokterPJ').val(dokter);
                $('#id_laporan_dbd').val(laporanId); // Use the specific report ID
            });

            // Handle lihat modal
            $(document).on('click', '[data-bs-target="#lihatModal"]', function() {
                var nama = $(this).data("nama");
                var usia = $(this).data("usia");
                var alamat = $(this).data("alamat");
                var gejalaEncoded = $(this).data("gejala");
                var gejalaLain = $(this).data("gejala_lain");
                var hasilLab = $(this).data("file_lab");
                if (hasilLab) {
                    var fileUrl = '/uploads/laporan/' + hasilLab;
                    $('#lihatHasilLab')
                        .attr('href', fileUrl)
                        .show();
                    $('.hasil-lab-empty').hide();
                } else {
                    $('#lihatHasilLab').hide();
                    $('.hasil-lab-empty').show();
                }
                var fileUrl = '/uploads/laporan/' + hasilLab;
                var created_at_data = $(this).data('created_at');
                var parser = new DOMParser();
                var decodedGejala = parser.parseFromString(gejalaEncoded, "text/html").body.textContent;
                var decodedCreatedAt = parser.parseFromString(created_at_data, "text/html").body
                    .textContent;

                var gejalaArray = JSON.parse(decodedGejala);
                var createdAtArray = JSON.parse(decodedCreatedAt);
                var htmlOutput = "";
                if (gejalaArray.length === createdAtArray.length) {
                    htmlOutput = "<ul>";
                    for (var i = 0; i < gejalaArray.length; i++) {
                        htmlOutput += "<li><strong>Tanggal:</strong> " + formatTimestamp(createdAtArray[
                                i]) +
                            " - <strong>Gejala:</strong> " + gejalaArray[i] + "</li>";
                    }
                    htmlOutput += "</ul>";

                    console.log(htmlOutput); // Output HTML
                    // You can inject the htmlOutput to your HTML container here.
                } else {
                    console.error("The length of gejalaArray and createdAtArray do not match.");
                }


                $("#lihatNama").val(nama);
                $("#lihatUsia").val(usia);
                $("#lihatAlamat").text(alamat);
                $("#lihatGejala").html(htmlOutput);
                $("#lihatGejalaLain").val(gejalaLain);
                $('#lihatHasilLab').attr('href', fileUrl);
            });

            // Handle form submission
            $('#LaporanForm').on('submit', function(e) {
                e.preventDefault();

                var laporanId = $("#id_laporan_dbd").val();
                $.ajax({
                    url: '/update-laporan/' + laporanId, // Use the specific report ID
                    method: 'PUT',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data Telah Di Validasi",
                            icon: "success"
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                        console.error(xhr, status, error);
                    }
                });
            });

            // Handle lihat detail pasien
            $(document).on('click', '.btnLihatPasien', function() {
                var pasienId = $(this).data('id');

                $.ajax({
                    url: '/get-pasien-detail/' + pasienId,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);

                        $('#lihatdetailnik').val(response.data.NIK);
                        $('#lihatdetailnama').val(response.data.nama);
                        $('#lihatdetailalamat').val(response.data.alamat);
                        $('#lihatEmail').val(response.data.email);
                        $('#lihatdetailusia').val(response.data.usia);
                        $('#lihatNamaDesa').val(response.data.desa.nama);
                        $('#lihatProvinsi').val(response.data.provinsi);
                        $('#lihatKabKota').val(response.data.kab_kota);
                        $('#lihatTempatLahir').val(response.data.tempat_lahir);
                        $('#lihatTanggalLahir').val(response.data.tanggal_lahir);
                        $('#lihatJenisKelamin').val(response.data.jenis_kelamin);
                        $('#lihatNoHp').val(response.data.no_hp);

                        $('#detailPasienModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan saat memuat data.",
                            icon: "error"
                        });
                    }
                });
            });

            // Handle lihat validasi lab
            $(document).on('click', '.btnValidasiLab', function() {
                var pasienId = $(this).data('id');

                console.log(pasienId);

                $.ajax({
                    url: '/accept_lab_by_admin/' + pasienId,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);


                        $('#currentHasilLab').show();
                        // Set source gambar
                        // $('#hasilLabPreview').attr('src', '/hasil_lab/' + response.data
                        //     .file_hasil_lab);
                        const img = `http://127.0.0.1:8000/hasil_lab/${response.data.file_hasil_lab}`;
                        console.log(img);
                        
                        $('#hasilLabPreview').attr('src',
                            `/hasil_lab/${response.data.file_hasil_lab}`);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan saat memuat data.",
                            icon: "error"
                        });
                    }
                });
            });

            // Initialize select2 if available
            if ($.fn.select2) {
                $('#dokterPJ').select2({
                    placeholder: "Pilih Dokter",
                    allowClear: true,
                    dropdownParent: $('#exampleModal')
                });
            }

            $('#hasilLabModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang membuka modal

                // Ambil data dari tombol
                var itemName = button.data('name');
                var itemId = button.data('id');
                $('#pasienIdHasilLab').val(itemId);
                console.log(itemId);
                // Isi input field dengan data
                var modal = $(this);
                modal.find('#itemName').val(itemName);
                modal.find('#itemId').val(itemId);
            });
        });
    </script>
@endsection
