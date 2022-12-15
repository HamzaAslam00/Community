@php
    $isEdit = isset($group) ? true : false;
    $url = $isEdit ? route('groups.update', $group->id) : route('groups.store');
@endphp
<form action="{{ $url }}" class="gy-3 form-settings form-validate is-alter" data-form="ajax-form" method="post" data-modal="#ajax_model" data-datatable="#groups_table">
    @csrf
    @if($isEdit)
        @method('put')
    @endif
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