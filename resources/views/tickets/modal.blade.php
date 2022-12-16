@php
    $isEdit = isset($ticket) ? true : false;
    $url = $isEdit ? route('admin.registration-pages.tickets.update', [$registrationPageId, $ticket->id]) : route('admin.registration-pages.tickets.store', $registrationPageId);
@endphp
<form action="{{ $url }}" class="gy-3 form-settings form-validate is-alter" data-form="ajax-form" method="post" data-modal="#ajax_model" data-datatable="#tickets_table">
    @csrf
    @if($isEdit)
        @method('put')
    @endif
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="title">Title</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="title" name="title" required value="{{ $isEdit ? $ticket->title : '' }}">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="amount">Amount($)</label>
                <div class="form-control-wrap">
                    <input type="number" min="0" step="0.01" class="form-control" id="amount" name="amount" required value="{{ $isEdit ? $ticket->amount : '' }}">
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <div class="form-control-wrap">
                    <textarea type="text" class="form-control" id="description" name="description">{{ $isEdit ? $ticket->description : '' }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select class="form-control form-select" id="status" name="status" required>
                    <option value="active" @if($isEdit && $ticket->status == 'active') selected @endif>Active</option>
                    <option value="inactive" @if($isEdit && $ticket->status == 'inactive') selected @endif>In-Active</option>
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