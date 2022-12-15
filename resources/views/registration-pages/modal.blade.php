@php
    $isEdit = isset($registrationPage) ? true : false;
    $url = $isEdit ? route('registration-pages.update', $registrationPage->id) : route('registration-pages.store');
@endphp
<form action="{{ $url }}" class="gy-3 form-settings form-validate is-alter" data-form="ajax-form" method="post" data-modal="#ajax_model" data-datatable="#registration_pages_table">
    @csrf
    @if($isEdit)
        @method('put')
    @endif
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="title">Title</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="title" name="title" required value="{{ $isEdit ? $registrationPage->title : '' }}" onfocusout="convertToSlug(this.value)">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="slug">Slug</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="slug" name="slug" required value="{{ $isEdit ? $registrationPage->slug : '' }}">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="default_groups">Default Groups</label>
                <select class="form-control form-select form-select-modal" id="default_groups" name="default_groups[]" multiple>
                    @foreach ($groups as $group)
                        <option value="{{ $group->id }}" @if($isEdit && in_array($group->id, $selected_groups)) selected @endif>{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select class="form-control form-select" id="status" name="status" required>
                    <option value="active" @if($isEdit && $registrationPage->status == 'active') selected @endif>Active</option>
                    <option value="inactive" @if($isEdit && $registrationPage->status == 'inactive') selected @endif>In-Active</option>
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
    $('.form-select-modal').select2();

    function convertToSlug(Text) {
        let slug = Text.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
        $('#slug').val(slug);
    };
</script>