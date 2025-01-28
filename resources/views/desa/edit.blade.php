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
        <form action="{{ route('desas.update',$desa->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" value="{{$desa->nama}}" name="nama">
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" value="{{$desa->longitude}}">
            </div>
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="{{$desa->latitude}}">
            </div>
            <div class="col-md-6">
                <label for="luas" class="form-label">luas wilayah</label>
                <input type="text" class="form-control" id="luas" name="luas" 
                value="{{$desa->luas}}">
            </div>
            <div class="col-md-6">
                <label for="kepadatan" class="form-label">kepadatan penduduk</label>
                <input type="text" class="form-control" id="kepadatan" name="kepadatan" value="{{$desa->kepadatan}}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
