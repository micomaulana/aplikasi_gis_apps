@extends('auth.layout')
@section('content')
    <div
        class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col col-xxl-6 mt-4 mb-4">
                    <div class="card mb-0">
                        <div class="card-body">
                            <h4 class="display-6 text-center"><b>GIS DBD</b></h4>
                            <p class="text-center">PUSKESMAS KARYA MAJU</p>
                            <form action="{{ route('register.post') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputtext1" class="form-label">NIK</label>
                                    <input type="text" class="form-control" id="NIK" name="NIK" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                        <option value="laki-laki">Laki-Laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                                </div>

                                <div class="mb-3">
                                    <label for="usia" class="form-label">Usia</label>
                                    <input type="number" class="form-control" id="usia" name="usia">
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat">
                                </div>

                                <!-- Nama Desa -->
                                <div class="mb-3">
                                    <label for="id_desa" class="form-label">Nama Desa</label>
                                    <select name="id_desa" class="form-control" id="id_desa">
                                        @foreach ($data_desas as $desa)
                                            <option value="{{ $desa->id }}">{{ $desa->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Provinsi -->
                                <div class="mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi"
                                        value="Sumatera Selatan" readonly>
                                </div>

                                <!-- Kab/Kota -->
                                <div class="mb-3">
                                    <label for="kab_kota" class="form-label">Kabupaten/Kota</label>
                                    <input type="text" class="form-control" id="kab_kota" name="kab_kota"
                                        value="Musi Banyuasin" readonly>
                                </div>

                                <!-- No HP -->
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label" id="label_no_hp">Nomor HP</label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp">
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label" id="label_email">E-Mail Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">Sign Up</button>
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                                    <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Sign In</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#select_desa').select2();

            $('#tanggal_lahir').on('change', function() {
                const tanggal_lahir = $(this).val();
                const date = new Date(tanggal_lahir);
                const year = date.getFullYear();
                const currentYear = new Date().getFullYear();
                const usia = currentYear - year;
                $('#usia').val(usia);
            });
        });
    </script>
@endsection
