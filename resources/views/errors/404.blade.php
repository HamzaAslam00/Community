@extends('errors::layout')

@section('title', __('Not Found'))

@section('body')
    <img class="nk-error-gfx" src="{{ asset('images/gfx/error-404.svg') }}" alt="">
    <div class="wide-xs mx-auto">
        <h3 class="nk-error-title">Oops! Why you’re here?</h3>
        <p class="nk-error-text">We are very sorry for inconvenience. It looks like you’re try to access a page that either has been deleted or never existed.</p>
        <a href="{{ url('/dashboar') }}d" class="btn btn-lg btn-primary mt-2">Back To Home</a>
    </div>
@endsection