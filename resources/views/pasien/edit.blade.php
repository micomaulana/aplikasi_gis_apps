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
        <form action="{{ route('pasiens.update',$pasien->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" value="{{$pasien->nama}}" name="nama">
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" value="{{$pasien->alamat}}" name="alamat">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" value="{{$pasien->email}}" name="email">
            </div>
            <div class="mb-3">
                <label for="usia" class="form-label">Usia</label>
                <input type="text" class="form-control" id="usia" value="{{$pasien->usia}}" name="usia">
            </div>
            <div class="mb-3">
                <label for="id_desa" class="form-label">Nama Desa </label>
                <select name="id_desa" class="form-control" id="id_desa">
                    @foreach ($data_desas as $desa)
                        <option value="{{ $desa->id }}">{{ $desa->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" class="form-control" id="provinsi" value="{{$pasien->provinsi}}" name="provinsi">
            </div>
            <div class="mb-3">
                <label for="kab_kota" class="form-label">Kab_kota</label>
                <input type="text" class="form-control" id="kab_kota" value="{{$pasien->kab_kota}}" name="kab_kota">
            </div>
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat_lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" value="{{$pasien->tempat_lahir}}" name="tempat_lahir">
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal_lahir</label>
                <input type="text" class="form-control" id="tanggal_lahir" value="{{$pasien->tanggal_lahir}}" name="tanggal_lahir">
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis_kelamin</label>
                <input type="text" class="form-control" id="jenis_kelamin" value="{{$pasien->jenis_kelamin}}" name="jenis_kelamin">
            </div>
            <div class="mb-3">
                <label for="diagnosis_lab" class="form-label">Diagnosis lab</label>
                <input type="text" class="form-control" id="diagnosis_lab" value="{{$pasien->diagnosis_lab}}" name="diagnosis_lab">
            </div>
            <div class="mb-3">
                <label for="diagnosis_klinis" class="form-label">Diagnosis klinis</label>
                <input type="text" class="form-control" id="diagnosis_klinis" value="{{$pasien->diagnosis_klinis}}" name="diagnosis_klinis">
            </div>
            <div class="mb-3">
                <label for="status_akhir" class="form-label">Status akhir</label>
                <input type="text" class="form-control" id="status_akhir" value="{{$pasien->status_akhir}}" name="status_akhir">
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No hp</label>
                <input type="text" class="form-control" id="no_hp" value="{{$pasien->no_hp}}" name="no_hp">
            </div>
            <div class="mb-3">
                <label for="tahun_terdata" class="form-label">Tahun terdata</label>
                <input type="text" class="form-control" id="tahun_terdata" value="{{$pasien->tahun_terdata}}" name="tahun_terdata">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
