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
                    <h4 class="nk-block-title">{{ $activationUrl->registrationPage->title }}</h4>
                    <div class="nk-block-des">
                        <p>Hi <b>{{ getFullName($activationUrl->user) }} <small>({{ $activationUrl->user->email }})</small></b><br>Pay the following tickets to activate your account.</p>
                    </div>
                </div>
            </div>
            <form method="post" action="{{ route('card-details', $activationUrl->registrationPage->slug) }}">
                @csrf
                <input type="hidden" value="{{ $activationUrl->id }}" name="activation_url_id">
                @foreach ($activationUrl->tickets as $ticket)
                    <div class="card">
                        <div class="card-inner">
                            <div class="d-flex justify-content-between">
                                <p>Ticket {{ $loop->index+1 }}</p>
                                <p>${{ $ticket->amount }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="form-group">
                    <button class="btn btn-lg btn-primary btn-block" style="margin-top: 28px">Pay Now (${{ array_sum($activationUrl->tickets->pluck('amount')->toArray()) }})</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('layouts.partials.footer')
@endsection