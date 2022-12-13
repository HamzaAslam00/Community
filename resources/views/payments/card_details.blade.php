@extends('layouts.guest')

@section('styles')

@endsection

@section('content')
<div class="nk-block nk-block-middle nk-auth-body wide-xs">
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
                    <h4 class="nk-block-title">{{ $activationUrl->registrationPage->title }}</h4>
                    <div class="nk-block-des">
                        <p>Provide payment card details to proceed next.</p>
                    </div>
                </div>
            </div>
            <form method="post" action="{{ route('login') }}" data-form="ajax-form" class="card-form">
                @csrf
                <div class="form-group">
                    <button class="btn btn-lg btn-primary btn-block" style="margin-top: 28px" data-button="submit">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('layouts.partials.footer')
@endsection