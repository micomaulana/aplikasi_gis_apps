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
                <input type="text" class="form-control" id="nama" value="{{$dokter->nama}}" name="nama" readonly>
            </div>
            <div class="mb-3">
                <label for="nip" class="form-label">Nip</label>
                <input type="text" class="form-control" id="nip" value="{{$dokter->nip}}" name="nip" readonly>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">status</label>
                <input type="status" class="form-control" id="status" value="{{$dokter->status}}" name="status" readonly>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" value="{{$dokter->email}}" name="email" readonly>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">alamat</label>
                <input type="text" class="form-control" id="alamat" value="{{$dokter->alamat}}" name="dokter" readonly>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">no hp</label>
                <input type="text" class="form-control" id="no_hp" value="{{$dokter->no_hp}}" name="no_hp" readonly>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">jenis kelamin</label>
                <input type="text" class="form-control" id="jenis_kelamin" value="{{$dokter->jenis_kelamin}}" name="jenis_kelamin" readonly>
            </div>
        </form>
    </div>
</div>
@endsection