@extends('errors::layout')

@section('title', __('Not Found'))

@section('body')
    <img class="nk-error-gfx" src="{{ asset('images/gfx/error-504.svg') }}" alt="">
    <div class="wide-xs mx-auto">
        <h3 class="nk-error-title">Gateway Timeout Error</h3>
        <p class="nk-error-text">We are very sorry for inconvenience. It looks like some how our server did not receive a timely response.</p>
        <a href="{{ url('/dashboar') }}d" class="btn btn-lg btn-primary mt-2">Back To Home</a>
    </div>
@endsection