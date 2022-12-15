@extends('layouts.app')

@section('title', '| Registration Pages')

@section('content')
    <div class="nk-block-head nk-block-head-lg pb-2">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title fw-normal">{{ $registrationPage->title }}</h3>
            </div>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <h6 class="register-url" data-toggle="tooltip" data-placement="top" title="Click to Copy">{{ route('register', $registrationPage->slug) }}</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-block nk-block-lg">
        <div class="card card-preview">
            <div class="card-inner">
                <ul class="nav nav-tabs mt-n3">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#overview-tab"><em class="icon ni ni-card-view"></em><span>Overview</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tickets-tab"><em class="icon ni ni-ticket-fill"></em><span>Tickets</span></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="overview-tab">
                        <div class="nk-block">
                            <div class="nk-block-head">
                                <div class="nk-block-between mb-5">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Page Details</h5>
                                    </div>
                                </div>
                                {{-- <p>Basic info, like your name and address, that you use on Nio Platform.</p> --}}
                                <div class="row mb-3">
                                    <div class="col-md-2"><h6 class="title">Title:</h6></div>
                                    <div class="col-md-10"><h6 class="title">{{ $registrationPage->title }}</h6></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2"><h6 class="title">Slug:</h6></div>
                                    <div class="col-md-10"><p>{{ $registrationPage->slug }}</p></div>
                                </div>
                                @if ($registrationPage->groups)
                                    <div class="row mb-3">
                                        <div class="col-md-2"><h6 class="title">Default Groups:</h6></div>
                                        <div class="col-md-10">
                                            <ul class="list list-sm list-checked">
                                                @foreach ($registrationPage->groups as $group)
                                                    <li>{{ $group->name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tickets-tab">
                        @include('tickets.index')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.register-url').mouseover(function(){
            $(this).css({'cursor':'pointer'});
            $(this).attr('data-original-title', "Click to Copy").tooltip('show');
        });
        $('.register-url').mouseout(function(){
            $(this).css({'background':'#f5f6fa', 'color':'#364a63', 'padding':'0px', 'border-radius':'0px'});
        });
        $('.register-url').click(function(){
            navigator.clipboard.writeText($(this).html());
            $(this).attr('data-original-title', "Copied!").tooltip('show');
            $(this).css({'background':'#318EFE', 'color':'white', 'padding':'4px', 'border-radius':'3px'});
        });
    </script>
@endpush    