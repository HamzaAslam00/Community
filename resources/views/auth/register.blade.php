@extends('layouts.guest')

@section('content')
<div class="nk-block nk-block-middle nk-auth-body  wide-xs">
    <div class="brand-logo pb-4 text-center">
        <a href="/" class="logo-link">
            <img class="logo-light logo-img logo-img-lg" src="{{ asset('images/logo.png') }}" alt="logo">
            <img class="logo-dark logo-img logo-img-lg" src="{{ asset('images/logo-dark.png') }}" alt="logo-dark">
        </a>
    </div>
    <div class="card">
        <div class="card-inner card-inner-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Sign-Up</h4>
                    <div class="nk-block-des">
                        <p>Contact admin to get register with the system.</p>
                    </div>
                </div>
            </div>
            <form action="{{ route('register') }}" class="gy-3 form-settings form-validate is-alter" method="POST" data-form="ajax-form">
                @csrf
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="first_name">First Name</label>
                    </div>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control form-control-lg" id="first_name" name="first_name" placeholder="Enter your first name address">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="last_name">Last Name</label>
                    </div>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control form-control-lg" id="last_name" name="last_name" placeholder="Enter your last name address">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="email">Email</label>
                    </div>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="Enter your email address">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-lg btn-primary btn-block" data-spinner="true" data-button="submit">Send</button>
                </div>
            </form>
            <div class="form-note-s2 text-center pt-4"> Already have an account? <a
                    href="{{ route('login') }}">Sign in instead</a>
            </div>
        </div>
    </div>
</div>
@include('layouts.partials.footer')
@endsection