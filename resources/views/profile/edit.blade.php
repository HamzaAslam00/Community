@extends('layouts.app')

@section('title', '| Profile')

@section('content')
    <div class="components-preview wide-md mx-auto">
        <div class="nk-block-head nk-block-head-lg pb-2">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title fw-normal">Profile</h3>
                </div>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            <div class="card card-preview">
                <div class="card-inner">
                    <ul class="nav nav-tabs mt-n3">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabItem4"><em class="icon ni ni-user-fill"></em><span>Profile</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabItem9"><em class="icon ni ni-lock-alt-fill"></em><span>Change Password</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabItem4">
                            <div class="nk-block">
                                <div class="nk-block-head">
                                    <h5 class="title">Profile Settings</h5>
                                    {{-- <p>Basic info, like your name and address, that you use on Nio Platform.</p> --}}
                                </div>
                                <form action="{{route('profile.update', $user->id)}}" class="gy-3 form-settings form-validate is-alter" method="POST" data-form="ajax-form" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="avatar">Avatar</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class=" logo">
                                                    <label for="logo-input">
                                                        <img id="logo" src="@if($user->avatar){{ getImage($user->avatar) }} @else {{ asset('assets/images/no_avatar.png')}}@endif" alt="profile image" style="max-width:100px;max-height:120px"/>
                                                        <input id="logo-input" preview="#logo" name="avatar" class="d-none" type='file' onchange="readURL(this);" />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label">Name</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}" placeholder="First name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}" placeholder="Last name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="email" readonly name="email" value="{{$user->email}}" placeholder="Email" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="phone">Phone Number</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="phone" name="phone" value="{{$user->phone}}" placeholder="Phone Number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="address">Address</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <textarea type="text" class="form-control" id="address" name="address" placeholder="Your Address">{{ $user->address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                        
                                    <div class="row g-3">
                                        <div class="col-lg-8 offset-lg-4">
                                            <div class="form-group mt-2">
                                                <button type="submit" class="btn btn-lg btn-primary" data-button="submit">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabItem9">
                            <h5 class="title mb-4">Change Password</h5>
                            <form action="{{route('profile.save_password', $user->id)}}" data-form="ajax-form" data-modal="#ajax_model" class="gy-3 form-validate is-alter" id='password_form' method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="password">New Password</label>
                                            <div class="form-control-wrap">
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="password_confirmation">Confirm New Password</label>
                                            <div class="form-control-wrap">
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var preview = $(input).attr('preview');
                $(preview).attr('src', e.target.result).css('max-width',150).css('max-height',120);
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    jQuery.validator.addMethod("regex", function(value, element) {
        return this.optional(element) || /^[A-Za-z ]+$/i.test(value);
    }, "Only alphabetic name is allow");
    $('.form-validate').validate({
            rules: {
            first_name: {
                required: true,
                regex: true
            },
            last_name: {
                required: true,
                regex: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                number: true,
                maxlength: 15
            },
        }
    });
</script>
@endpush