@extends('admin.Layouts.Master')
@section('content')
    <link rel="stylesheet" href="{{ asset('admin/css/login.css') }}">
    <div class="container-fluid ps-md-0">
        <div class="row g-0">
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image" style="background-image: url('{{ asset('admin/img/admin.jpg') }}')"></div>
            <div class="col-md-8 col-lg-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <h3 class="login-heading mb-4">Welcome back Admin !</h3>
                                <!-- Sign In Form -->
                                <form method="POST" action="{{ route('admin.post_login') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group has-float-label">
                                        <input name="email" value="{{ old('email') }}" type="text"
                                            class="form-control" id="email" placeholder="name@example.com" required>
                                        <label for="email">Email</label>
                                    </div>

                                    <div class="form-floating mb-3 has-float-label">
                                        <input name="password" value="{{ old('password') }}" type="password"
                                            class="form-control" id="floatingPassword" placeholder="Password" required>
                                        <label for="floatingPassword">Password</label>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-7 p-0">
                                            <div class="ml-3 g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
                                            </div>
                                            @if ($errors->has('g-recaptcha-response'))
                                                <span
                                                    class="text-danger ml-3">{{ $errors->first('g-recaptcha-response') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button style="background-color: #F84B2F;border-color: #F84B2F" class="col-12 btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2"
                                            type="submit">Sign in</button>
                                        <div class="text-center">
                                            <a style="color: #F84B2F" class="small" data-toggle="modal" data-target="#modalForGotPassword"
                                                href="#">Forgot password?</a>
                                        </div>
                                    </div>

                                </form>
                                <hr class="my-4">

                                <!-- Modal -->
                                <div class="modal fade" id="modalForGotPassword" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Forgot Password</h5>
                                                <button style="outline: none" type="button" class="close"
                                                    data-dismiss="modal" aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('admin.forgot_sendcode') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="staticEmail"
                                                            class="col-sm-2 col-form-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input name="email" type="email" class="form-control"
                                                                id="staticEmail" placeholder="email@example.com"
                                                                value="">
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" style="background-color: #F84B2F;border-color: #F84B2F">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
