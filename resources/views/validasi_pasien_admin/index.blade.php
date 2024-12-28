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
                            <!-- Tombol Lihat -->
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#lihatModal"
                                data-id="{{ $idPasien }}" data-nama="{{ $laporanList[0]['pasien']->nama ?? 'N/A' }}"
                                data-usia="{{ $laporanList[0]['pasien']->usia ?? 'N/A' }}"
                                data-alamat="{{ $laporanList[0]['pasien']->alamat ?? 'N/A' }}"
                                data-file_lab="{{ $laporanList[0]['file_hasil_lab'] }}"
                                data-gejala="{{ htmlspecialchars(json_encode($laporanList->pluck('gejala')), ENT_QUOTES, 'UTF-8') }}"
                                data-gejala_lain="{{ $laporanList[0]['gejala_lain'] }}">
                                <i class="fas fa-eye"></i> Lihat
                            </button>

                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                data-id="{{ $idPasien }}" data-status="{{ $laporanList[0]['status'] }}"
                                data-dokter="Dr. Budi">
                                <i class="fas fa-check"></i> Setuju
                            </button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#tolakModal"
                                data-id="{{ $idPasien }}">
                                <i class="fas fa-times"></i> Tolak
                            </button>
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
                        <a href="#" id="lihatHasilLab" target="_blank" class="form-control-link">Unduh Hasil Lab</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
                                        name="tanggal_control" required value="{{ old('id_lapora_kasus') }}">

                                    <input type="time" class="form-control" id="jadwalWaktu" name="waktu_control"
                                        required value="{{ old('waktu_control') }}">

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="dokterPJ" class="form-label">Dokter PJ</label>
                                <select class="form-select" id="dokterPJ" name="id_dokter" required>
                                    <option selected disabled>Pilih Dokter</option>
                                    @foreach ($dokters as $dokter)
                                        <option value="{{ $dokter->id }}"
                                            {{ old('id_dokter') == $dokter->id ? 'selected' : '' }}>
                                            {{ $dokter->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="catatanMedis" class="form-label">Catatan Medis</label>
                                <textarea class="form-control" id="catatanMedis" name="catatan_medis" rows="3"
                                    placeholder="Tambahkan catatan medis..." required>{{ old('catatan_medis') }}</textarea>
                            </div>
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
            // Tangkap event sebelum modal ditampilkan
            $(document).on('click', '[data-bs-target="#exampleModal"]', function() {
                var id = $(this).data('id'); // Ambil data-id
                var status = $(this).data('status'); // Ambil data-status
                var dokter = $(this).data('dokter'); // Ambil data-dokter

                // Isi data ke elemen-elemen modal
                $('#statusKasus').val(status); // Menyimpan status pada select status
                $('#dokterPJ').val(dokter); // Menyimpan dokter pada select dokter
                $('#id_laporan_dbd').val(id); // Menyimpan dokter pada select dokter
                console.log("ID:", id, "Status:", status, "Dokter:", dokter);
            });
            $(document).on('click', '[data-bs-target="#lihatModal"]', function() {
                // var id = $(this).data('id'); // Ambil data-id
                var nama = $(this).data("nama");
                var usia = $(this).data("usia");
                var alamat = $(this).data("alamat");
                var gejalaEncoded = $(this).data("gejala");
                var gejalaLain = $(this).data("gejala_lain");
                var hasilLab = $(this).data("file_lab");
                var fileUrl = '/uploads/laporan/' + hasilLab;
                var parser = new DOMParser();
                var decodedGejala = parser.parseFromString(gejalaEncoded, "text/html").body.textContent;

                var gejalaArray = JSON.parse(decodedGejala);
                var gejalaHtml = "<ul>";
                gejalaArray.forEach(function(item) {
                    gejalaHtml += "<li>" + item + "</li>";
                });
                gejalaHtml += "</ul>";


                console.log(hasilLab);

                // var dokter = $(this).data('dokter'); // Ambil data-dokter

                // Isi data ke elemen-elemen modal
                $("#lihatNama").val(nama); // Isi input field
                $("#lihatUsia").val(usia);
                $("#lihatAlamat").text(alamat); // Isi textarea
                $("#lihatGejala").html(gejalaHtml); // Isi textarea
                $("#lihatGejalaLain").val(gejalaLain); // Isi textarea
                $('#lihatHasilLab').attr('href', fileUrl); // Update link href
                // $('#dokterPJ').val(dokter); // Menyimpan dokter pada select dokter
                // $('#id_laporan_dbd').val(id); // Menyimpan dokter pada select dokter
                // console.log("ID:", id, "Status:", status, "Dokter:", dokter);
            });

            $('#LaporanForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah reload halaman
                console.log("submit form");

                $id = $("#id_laporan_dbd").val();
                $.ajax({
                    url: '/update-laporan/' + $id, // Endpoint Laravel
                    method: 'PUT',
                    data: $(this).serialize(), // Kirim data form
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val() // Token CSRF
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data Telah Di Validasi",
                            icon: "success"
                        }).then(() => {
                            location
                                .reload(); // This will reload the page when OK is clicked
                        });
                        console.log(response);


                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                        console.error(xhr, status, error);
                    }
                });
            });
        });
    </script>
@endsection
