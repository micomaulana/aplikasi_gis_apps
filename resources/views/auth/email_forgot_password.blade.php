@extends('auth.layout')
@section('content')
    <div
        class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <h4 class="display-6 text-center"><b>GIS DBD</b></h4>
                            <p class="text-center">PUSKESMAS KARYA MAJU</p>
                            <form action="{{ route('send_email') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="email" placeholder="Masukkan Email">
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-4">
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">Kirim</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
