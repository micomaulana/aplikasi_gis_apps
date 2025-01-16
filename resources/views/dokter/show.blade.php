@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <p class="mb-0">{{ $message }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Detail Dokter</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama</label>
                            <p class="form-control">{{ $dokter->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">NIP</label>
                            <p class="form-control">{{ $dokter->nip }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p class="form-control">{{ $dokter->status }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <p class="form-control">{{ $dokter->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat</label>
                            <p class="form-control">{{ $dokter->alamat }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor HP</label>
                            <p class="form-control">{{ $dokter->no_hp }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Kelamin</label>
                            <p class="form-control">{{ ucfirst($dokter->jenis_kelamin) }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Jadwal Praktek</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Hari Praktek</label>
                                    <p class="form-control">
                                        @php
                                            $hari_array = explode(',', $dokter->hari);
                                            echo ucwords(implode(', ', $hari_array));
                                        @endphp
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Jam Mulai</label>
                                            <p class="form-control">{{ $dokter->jam_mulai }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Jam Selesai</label>
                                            <p class="form-control">{{ $dokter->jam_selesai }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deskripsi</label>
                                    <p class="form-control">{{ $dokter->deskripsi ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('dokters.index') }}" class="btn btn-secondary">Kembali</a>
                    @if (Auth::user()->can('dokter-edit'))
                        <a href="{{ route('dokters.edit', $dokter->id) }}" class="btn btn-primary">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
