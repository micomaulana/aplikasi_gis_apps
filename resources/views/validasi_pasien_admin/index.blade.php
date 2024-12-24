@extends('layouts.main')
@section('content')
    <div class="container-fluid mt-5">
        <div class="card custom-card shadow-card">
            <div class="card-header">
                Validasi laporan kasus dbd
            </div>
            <div class="card-body custom-card-body">
                <div>
                    <h6>Total laporan</h6>
                    <h3>1</h3>
                </div>
                <div>
                    <h6>Menunggu Validasi</h6>
                    <h3>0</h3>
                </div>
                <div>
                    <h6>Terkonfirmasi</h6>
                    <h3>1</h3>
                </div>
                <div>
                    <h6>Ditolak</h6>
                    <h3>0</h3>
                </div>
            </div>
        </div>

        <h5 class="mt-4">Daftar Laporan</h5>
        <table class="table table-bordered mt-2 custom-table">
            <thead class="table-light">
                <tr>
                    <th>No. tiket</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>DBD-2024-001</td>
                    <td>22 Maret 2024</td>
                    <td>Sri Utami</td>
                    <td>Desa Karya Maju Blok C</td>
                    <td class="custom-status">Menunggu Validasi</td>
                    <td>
                        <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                        <button class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
