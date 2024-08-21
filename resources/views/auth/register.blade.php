@extends('layouts.auth')

@section('title')
Register
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
                                    <h2 class="mb-2 text-white">Sign Up</h2>
                                    <p>Create your account to start manage your project</p>
                                    <form method="POST" action="{{ route('register.store') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control @error('name') is-invalid @enderror" type="text" placeholder=" " name="name" value="{{ old('name') }}" required>
                                                    <label>Full Name</label>
                                                    @if ($errors->has('name'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('name') }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control @error('email') is-invalid @enderror" type="email" placeholder=" " name="email" id="email" value="{{ old('email') }}" required>
                                                    <label>Email</label>
                                                    @if ($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control @error('phone') is-invalid @enderror" type="text" placeholder=" " name="phone" value="{{ old('phone') }}" required>
                                                    <label>Phone No.</label>
                                                    @if ($errors->has('phone'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('phone') }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
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
                                                <div class="floating-label form-group">
                                                    <input class="floating-input form-control @error('password') is-invalid @enderror" type="password" placeholder=" " name="password_confirmation" required>
                                                    <label>Confirm Password</label>
                                                    @if ($errors->has('password'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('password') }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-white">Sign Up</button>
                                        <p class="mt-3">
                                            Already have an Account <a href="{{ route('login') }}"
                                                class="text-white text-underline">Sign In</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-5 content-right">
                                <img src="{{ asset('images/login/01.png') }}" class="img-fluid image-right" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('additional_scripts')
<script>
    document.querySelector('input[name="name"]').addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });

    document.querySelector('input[name="email"]').addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });

    document.querySelector('input[name="phone"]').addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });

    document.querySelector('input[name="password"]').addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });

    document.querySelector('input[name="password_confirmation"]').addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });
</script>
@endsection
