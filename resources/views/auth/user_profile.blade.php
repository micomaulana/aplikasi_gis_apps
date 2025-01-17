@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Profil</h4>
                    </div>
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

                        <form action="{{ route('update_user_profile') }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if (Auth::user()->hasRole('Pasien'))
                                <div class="form-group row">
                                    <label for="NIK" class="col-md-4 col-form-label text-md-right">NIK</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="NIK" name="NIK"
                                            value="{{ $user->NIK }}">
                                    </div>
                                </div>
                            @endif

                            @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kepala Puskes'))
                                <div class="form-group row">
                                    <label for="nama" class="col-md-4 col-form-label text-md-right">Nama</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->name }}">
                                    </div>
                                </div>
                            @endif

                            @if (Auth::user()->hasRole('Pasien'))
                                <div class="form-group row">
                                    <label for="nama" class="col-md-4 col-form-label text-md-right">Nama</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ $user->nama }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="jenis_kelamin" class="col-md-4 col-form-label text-md-right">Jenis
                                        Kelamin</label>
                                    <div class="col-md-6">
                                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                            <option value="Laki-laki"
                                                {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="Perempuan"
                                                {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tempat_lahir" class="col-md-4 col-form-label text-md-right">Tempat
                                        Lahir</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                            value="{{ $user->tempat_lahir }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tanggal_lahir" class="col-md-4 col-form-label text-md-right">Tanggal
                                        Lahir</label>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                            value="{{ $user->tanggal_lahir }}" onchange="calculateAge()">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="usia" class="col-md-4 col-form-label text-md-right">Usia</label>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" id="usia" name="usia"
                                            value="{{ $user->usia }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="alamat" class="col-md-4 col-form-label text-md-right">Alamat</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $user->alamat }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="provinsi" class="col-md-4 col-form-label text-md-right">Provinsi</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="provinsi" name="provinsi"
                                            value="{{ $user->provinsi }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="kab_kota"
                                        class="col-md-4 col-form-label text-md-right">Kabupaten/Kota</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="kab_kota" name="kab_kota"
                                            value="{{ $user->kab_kota }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_hp" class="col-md-4 col-form-label text-md-right">No HP</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                                            value="{{ $user->no_hp }}">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update Profil
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateAge() {
            var tanggalLahir = new Date(document.getElementById('tanggal_lahir').value);
            var today = new Date();
            var age = today.getFullYear() - tanggalLahir.getFullYear();
            var monthDiff = today.getMonth() - tanggalLahir.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < tanggalLahir.getDate())) {
                age--;
            }
            document.getElementById('usia').value = age;
        }

        // Panggil fungsi calculateAge saat halaman dimuat
        window.onload = calculateAge;
    </script>
@endsection
