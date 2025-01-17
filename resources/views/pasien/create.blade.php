@extends('layouts.main')
@section('content')
    <div class="container-fluid">
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
            <form action="{{ route('pasiens.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="NIK" class="form-label">NIK</label>
                    <input type="text" class="form-control" id="NIK" name="NIK">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                        <option value="laki-laki">Laki-Laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                </div>
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                </div>
                <div class="mb-3">
                    <label for="usia" class="form-label">Usia</label>
                    <input type="text" class="form-control" id="usia" name="usia" readonly>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat">
                </div>
                <div class="mb-3">
                    <label for="id_desa" class="form-label">Nama Desa</label>
                    <select name="id_desa" class="form-control" id="select_desa">
                        @foreach ($data_desas as $desa)
                            <option value="{{ $desa->id }}">{{ $desa->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="provinsi" class="form-label">Provinsi</label>
                    <input type="text" class="form-control" id="provinsi" name="provinsi" value="Sumatera Selatan" readonly>
                </div>
                <div class="mb-3">
                    <label for="kab_kota" class="form-label">Kab/Kota</label>
                    <input type="text" class="form-control" id="kab_kota" name="kab_kota" value="Musi Banyuasin" readonly>
                </div>
                <div class="mb-3">
                    <label for="diagnosis_lab" class="form-label">Diagnosis Lab</label>
                    <input type="text" class="form-control" id="diagnosis_lab" name="diagnosis_lab">
                </div>
                <div class="mb-3">
                    <label for="diagnosis_klinis" class="form-label">Diagnosis Klinis</label>
                    <input type="text" class="form-control" id="diagnosis_klinis" name="diagnosis_klinis">
                </div>
                <div class="mb-3">
                    <label for="status_akhir" class="form-label">Status Akhir</label>
                    <input type="text" class="form-control" id="status_akhir" name="status_akhir">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label" id="label_email">Email</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label" id="label_no_hp">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp">
                </div>
                <div class="mb-3">
                    <label for="tahun_terdata" class="form-label">Tanggal Terdata</label>
                    <input type="date" class="form-control" id="tahun_terdata" name="tahun_terdata">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>


        <script>
            $(document).ready(function() {
                $('#select_desa').select2();
                $('#usia').attr('readonly');



                $('#tanggal_lahir').on('change', function() {
                    const tanggal_lahir = $(this).val();
                    const date = new Date(tanggal_lahir);
                    const year = date.getFullYear();
                    const currentYear = new Date().getFullYear();
                    const usia = currentYear - year;
                    $('#usia').val(usia);

                    if (usia < 17) {
                            $('#email').hide();
                            $('#no_hp').hide();
                            $('#label_no_hp').hide();
                            $('#label_email').hide();
                        } else {
                            $('#email').show();
                            $('#no_hp').show();
                            $('#label_no_hp').show();
                            $('#label_email').show();
                        }
                });
            });
        </script>
    @endsection
