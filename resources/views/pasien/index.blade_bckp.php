@extends('layouts.main')
@section('content')

</div>
<div class="pull-right">
  <a class="btn btn-success" href=" {{
  route('pasiens.create') }}"> create new </a>
</div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>nama</th>
                <th>alamat</th>
                <th>usia</th>
                <th>Nama Desa</th>
                <th>provinsi</th>
                <th>kab_kota</th>
                <th>tempat_lahir</th>
                <th>tanggal_lahir</th>
                <th>jenis_kelamin</th>
            </tr>
        </thead>
        <tbody>
                @foreach ($pasiens as $key => $pasien)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $pasien->nama }}</td>
                        <td>{{ $pasien->alamat }}</td>
                        <td>{{ $pasien->usia }}</td>
                        <td>{{ $pasien->desa->nama ?? 'N\A' }}</td>
                        <td>{{ $pasien->provinsi }}</td>
                        <td>{{ $pasien->kab_kota}}</td>
                        <td>{{ $pasien->tempat_lahir }}</td>
                        <td>{{ $pasien->tanggal_lahir }}</td>
                        <td>{{ $pasien->jenis_kelamin}}</td>
                        <td>
                            <form action="{{ route('pasiens.destroy', $pasien->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <a type="button" class="btn btn-info" href="{{ route('pasiens.show', $pasien->id) }}">Show</a>
                                <a type="button" class="btn btn-warning" href="{{ route('pasiens.edit', $pasien->id) }}">Edit</a>
                                <button type="submit" class="btn btn-danger">Delete</a>
                            </form>
                        </td>
                        {{-- <td>{{ $desa->longitude }}</td>
                        <td>{{ $desa->latitude }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pasiens->links() }}
    @endsection
