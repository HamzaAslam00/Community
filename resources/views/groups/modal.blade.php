@php
    $isEdit = isset($group) ? true : false;
    $url = $isEdit ? route('admin.groups.update', $group->id) : route('admin.groups.store');
@endphp
<form action="{{ $url }}" class="gy-3 form-settings form-validate is-alter" data-form="ajax-form" method="post" data-modal="#ajax_model" data-datatable="#groups_table" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('put')
    @endif
    <div class="row g-3 align-center">
        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-label" for="group_image">Group Image</label>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="form-group">
                <div class="logo">
                    <label for="logo-input">
                        <img id="logo" src="{{ $isEdit && isset($group->image) ? getImage($group->image) : asset('assets/images/no_image.png') }}" alt="group icon" style="max-width:100px;max-height:120px"/>
                        <input id="logo-input" preview="#logo" name="group_image" class="d-none" type='file' onchange="readURL(this);" />
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="name">Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="name" name="name" required value="{{ $isEdit ? $group->name : '' }}">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select class="form-control form-select" id="status" name="status" required>
                    <option value="active" @if($isEdit && $group->status == 'active') selected @endif>Active</option>
                    <option value="inactive" @if($isEdit && $group->status == 'inactive') selected @endif>In-Active</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <div class="form-control-wrap">
                    <textarea type="text" class="form-control" id="description" name="description" required>{{ $isEdit ? $group->description : '' }}</textarea>
                </div>
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