@extends('layouts.app')

@section('title', '| Join Groups')

@section('content')
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h3 class="title nk-block-title">Groups List</h3>
                <p>We have total {{ $groups->count() }} new groups for you.</p>
            </div>
        </div>
        <div class="row g-gs">
            @foreach ($groups as $group)
                <div class="col-sm-4 col-lg-3 col-xxl-2">
                    <div class="card">
                        <div class="card-inner">
                            <div class="team">
                                <div class="user-card user-card-s2">
                                    <div class="user-avatar lg bg-primary">
                                        <img src="{{ getImage($group->image) }}" alt="" style="height:inherit">
                                        <div class="status dot dot-lg dot-success"></div>
                                    </div>
                                    <div class="user-info">
                                        <h6>{{ $group->name }}</h6>
                                        {{-- <span class="sub-text">UI/UX Designer</span> --}}
                                    </div>
                                </div>
                                <ul class="team-info text-center">
                                    <li class="d-block"><span>{{ addEllipsis($group->description) }}</span></li>
                                </ul>
                                <div class="team-view">
                                    <a href="#" class="btn btn-block btn-dim btn-primary"><span>Join</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection