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
        <form>
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" value="{{$pasien->nama}}" name="nama" readonly>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" value="{{$pasien->alamat}}" name="alamat" readonly>
            </div>
            <div class="mb-3">
                <label for="usia" class="form-label">Usia</label>
                <input type="text" class="form-control" id="usia" value="{{$pasien->usia}}" name="usia" readonly>
            </div>
            <div class="mb-3">
                <label for="id_desa" class="form-label">Desa </label>
                <input type="text" class="form-control" id="id_desa" value="{{$pasien->desa->nama}}" name="id_desa" readonly>
            </div>
            <div class="mb-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" class="form-control" id="provinsi" value="{{$pasien->provinsi}}" name="provinsi" readonly>
            </div>
            <div class="mb-3">
                <label for="kab_kota" class="form-label">Kab_kota</label>
                <input type="text" class="form-control" id="kab_kota" value="{{$pasien->kab_kota}}" name="kab_kota" readonly>
            </div>
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat_lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" value="{{$pasien->tempat_lahir}}" name="tempat_lahir" readonly>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal_lahir</label>
                <input type="text" class="form-control" id="tanggal_lahir" value="{{$pasien->tanggal_lahir}}" name="tanggal_lahir" readonly>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis_kelamin</label>
                <input type="text" class="form-control" id="jenis_kelamin" value="{{$pasien->jenis_kelamin}}" name="jenis_kelamin" readonly>
            </div>
            <div class="mb-3">
                <label for="diagnosis_lab" class="form-label">Diagnosis_lab</label>
                <input type="text" class="form-control" id="diagnosis_lab" value="{{$pasien->diagnosis_lab ?? "Belum Dilakukan Analisis LAB"}}" name="diagnosis_lab" readonly>
            </div>
            <div class="mb-3">
                <label for="diagnosis_klinis" class="form-label">diagnosis_klinis</label>
                <input type="text" class="form-control" id="diagnosis_klinis" value="{{$pasien->diagnosis_klinis ?? "Belum Dilakukan Analisis klinis"}}" name="diagnosis_klinis" readonly>
            </div> 
            <div class="mb-3">
                <label for="status_akhir" class="form-label">Status_akhir</label>
                <input type="text" class="form-control" id="status_akhir" value="{{$pasien->status_akhir}}" name="status_akhir" readonly>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">no hp</label>
                <input type="text" class="form-control" id="no_hp" value="{{$pasien->no_hp}}" name="no_hp" readonly>
            </div>
            <div class="mb-3">
                <label for="tahun_terdata" class="form-label">tahun_terdata</label>
                <input type="text" class="form-control" id="tahun_terdata" value="{{$pasien->tahun_terdata}}" name="tahun_terdata" readonly>
            </div>
        </form>
    </div>
</div>
@endsection