@extends('layouts.app')

@section('title', '| Activation Urls')
@section('content')

@php
    $isEdit = isset($activationUrl) ? true : false;
    $url = $isEdit ? route('activation-urls.update', $activationUrl) : route('activation-urls.store');
@endphp

    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">{{ $isEdit ? 'Edit' : 'Create' }} Activation Urls</h4>
                </div>
                <a href="{{ route('activation-urls.index') }}" class="btn btn-primary btn-sm d-none d-md-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
            </div>
        </div>
        <div class="card">
            <div class="card-inner">
                @include('activation-urls.form')
            </div>
        </div>
    </div>
@endsection