@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @elseif($message = Session::get('fails'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @else
            <div class="message"></div>
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
            <form action="{{ route('simpan_laporan_masyarakat') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" value="{{ $pasien->nama }}"
                        name="nama_lengkap" readonly>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input class="form-control" id="alamat" name="alamat" value="{{ $pasien->alamat }}">
                </div>
                <div class="mb-3">
                    <label for="usia" class="form-label">Usia</label>
                    <input type="number" class="form-control" id="usia" name="usia" value="{{ $pasien->usia }}"
                        readonly>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="tel" class="form-control" id="no_hp" name="no_hp" value="{{ $pasien->no_hp }}"
                        readonly>
                </div>
                <div class="mb-3">
                    <label for="gejala" class="form-label">Gejala yang Dialami</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Sakit kepala" id="gejala1"
                            name="gejala_yang_dialami[]">
                        <label class="form-check-label" for="gejala1">Sakit kepala</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Demam tinggi" id="gejala2"
                            name="gejala_yang_dialami[]">
                        <label class="form-check-label" for="gejala2">Demam tinggi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Nyeri sendi" id="gejala3"
                            name="gejala_yang_dialami[]">
                        <label class="form-check-label" for="gejala3">Nyeri sendi</label>
                    </div>
                    <textarea class="form-control mt-2" id="gejala_lain" name="gejala_lain" placeholder="Gejala lain"></textarea>
                </div>
                <div class="mb-3">
                    <label for="hasil_lab" class="form-label">
                        Upload Hasil Lab
                        <span class="text-muted">(Opsional)</span>
                    </label>
                    <input type="file" class="form-control" id="hasil_lab" name="file_hasil_lab"
                        accept=".pdf,.jpg,.jpeg,.png">
                    <small class="form-text text-muted">
                        Anda dapat mengunggah hasil lab nanti jika belum tersedia. Format yang diterima: PDF, JPG, PNG (max
                        2MB)
                    </small>
                    </div>=".pdf,.jpg,.jpeg,.png">
                </div>
                <button type="submit" class="btn btn-primary">Kirim Laporan</button>
            </form>
        </div>
    </div>
@endsection
