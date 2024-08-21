@extends('layouts.auth')

@section('title')
Login
@endsection

@section('content')
<section class="login-content">
    <div class="container">
        <div class="row align-items-center justify-content-center height-self-center">
            <div class="col-lg-8">
                @if (session('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-alert-line"></i>
                    </div>
                    <div class="iq-alert-text">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
                @endif

                @if (session('error'))
                <div class="alert text-white bg-secondary" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-alert-line"></i>
                    </div>
                    <div class="iq-alert-text">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert text-white bg-secondary" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-alert-line"></i>
                    </div>
                    <div class="iq-alert-text">
                        Invalid input. Please check and try again.
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
                @endif

                <div class="card auth-card">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-center auth-content">
                            <div class="col-lg-7 bg-primary content-left">
                                <div class="p-3">
                                    <h2 class="mb-2 text-white">Sign In</h2>
                                    <p>Login to stay connected.</p>
                                    <form method="POST" action="{{ route('login.store') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control @error('email') is-invalid @enderror" type="email" placeholder=" " name="email" value="{{ old('email') }}" required>
                                                    <label>Email</label>
                                                    @if ($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control @error('password') is-invalid @enderror" type="password" placeholder=" " name="password" required>
                                                    <label>Password</label>
                                                    @if ($errors->has('password'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('password') }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                                    <label class="custom-control-label control-label-1 text-white" for="remember">Remember Me</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-white">Sign In</button>
                                        <p class="mt-3">
                                            Create an Account <a href="{{ route('register') }}" class="text-white text-underline">Sign Up</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-5 content-right">
                                <img src="{{ asset('assets/images/login/01.png') }}" class="img-fluid image-right" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
