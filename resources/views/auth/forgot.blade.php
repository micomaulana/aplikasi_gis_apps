@extends('auth.layout')
@section('content')
    <div
        class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <img src="/Seodash-assets/images/logos/logo-light.svg" alt="">
                            </a>
                            <p class="text-center">Your Social Campaigns</p>
                            <form action="{{route('update_forgot_password')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">New Password</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="email" value="{{$email}}" hidden>
                                    <input type="password" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="password">
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
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
