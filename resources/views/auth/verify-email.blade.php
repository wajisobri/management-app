@extends('layouts.auth')

@section('title')
Verify Email
@endsection

@section('content')
<section class="login-content">
    <div class="container">
        <div class="row align-items-center justify-content-center height-self-center">
            <div class="col-lg-8">
                <div class="card auth-card">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-center auth-content">
                            <div class="col-lg-7 bg-primary content-left">
                                <div class="p-3">
                                    <img src="../assets/images/login/mail.png" class="img-fluid" width="80" alt="">
                                    <h2 class="mt-3 mb-0 text-white">Success !</h2>
                                    <p class="cnf-mail mb-1">A email has been send to {{ Session::get('email') }}. Please check for an email from us and click on the included link to verify your account.</p> If you haven't received an email from us, please click on the below button to resend the verification email.
                                    <form method="POST" action="{{ route('verification.send') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ Session::get('id') }}">
                                        <input type="hidden" name="email" value="{{ Session::get('email') }}">
                                        <div class="d-inline-block w-100">
                                            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="btn btn-white mt-3 mr-2">Resend Email</a>
                                            <a href="{{ route('dashboard') }}" class="btn btn-white mt-3">Back to Home</a>
                                        </div>
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
