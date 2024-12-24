@extends('layouts.main')
@section('content')
    <div class="container-fluid mt-5">
        <form action="{{ route('update-data-statistik',$statistik->id)}}" method="POST">
            @csrf
            @method('PUT')
            <h5 class="card-title">Edit Data Statistik</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="desa" class="form-label">Nama desa</label>
                    <select id="desa" class="form-select" name="id_desa">
                        <option selected disabled>Pilih desa</option>
                        @foreach ($desas as $desa)
                            <option value="{{ $desa->id }}" {{ $desa->id == $statistik->id_desa ? 'selected' : '' }}>
                                {{ $desa->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="kasus" class="form-label">Jumlah kasus</label>
                    <input type="number" name="jumlah_kasus" id="kasus" class="form-control"
                        placeholder="Masukkan jumlah kasus" value="{{ $statistik->jumlah_kasus }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option selected disabled>Pilih status</option>
                        <option value="tinggi" {{ $statistik->status == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        <option value="rendah" {{ $statistik->status == 'rendah' ? 'selected' : '' }}>Rendah</option>
                        <option value="sedang" {{ $statistik->status == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="penduduk" class="form-label">Jumlah penduduk</label>
                    <input type="number" id="penduduk" name="jumlah_penduduk" class="form-control"
                        placeholder="Masukkan jumlah penduduk" value="{{ $statistik->jumlah_penduduk }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fogging" class="form-label">Tanggal fogging terakhir</label>
                    <input type="date" id="fogging" name="tanggal_fogging" class="form-control"
                        value="{{ $statistik->tanggal_fogging }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary d-flex ms-auto">Update Data</button>
        </form>
    </div>
@endsection
