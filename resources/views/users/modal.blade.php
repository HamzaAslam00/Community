@php
    $isEdit = isset($user) ? true : false;
    $url = $isEdit ? route('users.update', $user->id) : route('users.store');
@endphp
<form action="{{ $url }}" class="gy-3 form-settings form-validate is-alter" data-form="ajax-form" method="post" data-modal="#ajax_model" data-datatable="#users_table" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('put')
    @endif
    <div class="row g-3 align-center">
        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-label" for="dashboard_title">Avatar</label>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="form-group">
                <div class=" logo">
                    <label for="logo-input">
                        <img id="logo" src="{{ $isEdit && isset($user->avatar) ? getImage($user->avatar) : asset('assets/images/no_avatar.png') }}" alt="store logo" class="" style="max-width:100px;max-height:120px"/>
                        <input id="logo-input" preview="#logo" name="avatar" class="d-none" type='file' onchange="readURL(this);" />
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="first_name">First Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="first_name" name="first_name" required value="{{ $isEdit ? $user->first_name : '' }}">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="last_name">Last Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="last_name" name="last_name" required value="{{ $isEdit ? $user->last_name : '' }}">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="form-control-wrap">
                    <input type="email" class="form-control" id="email" name="email" required value="{{ $isEdit ? $user->email : '' }}">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select class="form-control form-select" id="status" name="status" required>
                    <option value="active" @if($isEdit && $user->status == 'active') selected @endif>Active</option>
                    <option value="inactive" @if($isEdit && $user->status == 'inactive') selected @endif>In-Active</option>
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <button type="submit" class="btn btn-md btn-primary" data-button="submit">Save</button>
            </div>
        </div>
    </div>
</form>

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
    }
</script>