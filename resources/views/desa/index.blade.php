@extends('layouts.main')
@section('content')
    <div class="container-fluid">

        <div class="pull-right">
            <a class="btn btn-success" href=" {{ route('desas.create') }}"> create new </a>
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
                    <th>action</th>
                    {{-- <th>longitude</th> --}}
                    {{-- <th>latitude</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($desas as $desa)
                    <tr>
                        <td>{{ $desa->id }}</td>
                        <td>{{ $desa->nama }}</td>
                        <td>
                            <form action="{{ route('desas.destroy', $desa->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <a type="button" class="btn btn-info" href="{{ route('desas.show', $desa->id) }}">Show</a>
                                <a type="button" class="btn btn-warning"
                                    href="{{ route('desas.edit', $desa->id) }}">Edit</a>
                                <button type="submit" class="btn btn-danger">Delete</a>
                            </form>
                        </td>
                        {{-- <td>{{ $desa->longitude }}</td>
                    <td>{{ $desa->latitude }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $desas->links() }}
    </div>
@endsection
