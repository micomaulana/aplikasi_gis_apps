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
        <form action="{{ route('dokters.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" value="{{$dokter->nama}}" name="nama">
            </div>
            <div class="mb-3">
                <label for="nip" class="form-label">nip</label>
                <input type="text" class="form-control" id="nip" value="{{$dokter->nip}}" name="nip">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" value="{{$dokter->status}}" name="status">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" value="{{$dokter->email}}" name="email">
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" value="{{$dokter->alamat}}" name="alamat">
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No hp</label>
                <input type="text" class="form-control" id="no_hp" value="{{$dokter->no_hp}}" name="no_hp">
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis_kelamin</label>
                <input type="text" class="form-control" id="jenis_kelamin" value="{{$dokter->jenis_kelamin}}" name="jenis_kelamin">
            </div>
    
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
