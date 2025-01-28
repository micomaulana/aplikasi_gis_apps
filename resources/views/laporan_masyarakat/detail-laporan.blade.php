@extends('layouts.main')
@section('content')
    <div class="container-fluid mt-4">
        <h5>Detail Laporan DBD</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Tahun</th>
                        <th>Nama Pasien</th>
                        <th>Gejala Penyakit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detaillaporanbyidpasien as $index => $dl)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $dl->tanggal }}</td>
                            <td>{{ $dl->tahun }}</td>
                            <td>{{ $dl->pasien->nama }}</td>
                            <td>{{ $dl->gejala }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
    