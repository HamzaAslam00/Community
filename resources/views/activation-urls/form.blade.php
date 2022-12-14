<form class="gy-3 form-validate user-form is-alter" action="{{ $url }}" data-form="ajax-form" method="post"  data-datatable="#activation_urls_table" data-redirect="{{ route('activation-urls.index') }}">
    @csrf
    @if($isEdit)
        @method('put')
    @endif
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="registration_page_id">Registration Page</label>
                <select class="form-control form-select" id="registration_page_id" name="registration_page_id" required>
                    <option value="" selected></option>
                    @foreach ($registrationPages as $registrationPage)
                        <option value="{{ $registrationPage->id }}" @if($isEdit && $registrationPage->id == $activationUrl->registration_page_id) selected @endif>{{ $registrationPage->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="tickets">Tickets</label>
                <select class="form-control form-select form-select-modal" id="tickets" name="tickets[]" multiple>
                    @foreach ($tickets as $ticket)
                        <option value="{{ $ticket->id }}" @if($isEdit && in_array($ticket->id, $activationUrl->tickets->pluck('id')->toArray())) selected @endif>{{ $ticket->amount }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="user_id">User</label>
                <select class="form-control form-select form-select-modal" id="user_id" name="user_id">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @if($isEdit && $user->id == $activationUrl->user->id) selected @endif>{{ getFullName($user) }} (<small>{{ $user->email }}</small>)</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($isEdit)
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-control form-select" id="status" name="status" required>
                        <option value="active" @if($activationUrl->status == 'active') selected @endif>Active</option>
                        <option value="inactive" @if($activationUrl->status == 'inactive') selected @endif>In-Active</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-label">Url</label>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" id="url" value="{{ $activationUrl->url }}" disabled>
                    </div>
                </div>
            </div>
        @endif
        {{-- <div class="row g-4">
            <div class="col-lg-12">
                <h5 class="card-title">Default Groups</h5>
            </div>
            <div class="align-self-end col-lg-12">
                <div class="custom-control custom-control-md custom-checkbox custom-control">
                    <input type="checkbox" class="custom-control-input assign-all" id="assign_all" @if($isEdit && ($groups->count() == $activationUrl->groups->count())) checked @endif>
                    <label class="custom-control-label text-capitalize" for="assign_all">Assign all groups</label>
                </div>
            </div>
        </div>
        <div class="row g-4 groups-section">
            @foreach($groups as $group)
                <div class="col-lg-2">
                    <div class="custom-control custom-control-md custom-checkbox custom-control pb-2">
                        <input type="checkbox" class="custom-control-input" value="{{$group->id}}" id="group_{{$group->id }}" name="groups[]" @if($isEdit && in_array($group->id, $activationUrl->groups->pluck('id')->toArray())) checked @endif>
                        <label class="custom-control-label text-capitalize" for="group_{{$group->id }}">{{ $group->name}}</label>
                    </div>
                </div>
            @endforeach
        </div> --}}
        <div class="row col-lg-12">
            <div class="form-group">
                <button type="submit" class="btn btn-md btn-primary" data-button="submit">Save</button>
            </div>
        </div>
    </div>
</form>

{{-- @push('scripts')
    <script>
        $(document).on('click', '.assign-all', function() {
            if($(this).is(':checked')) {
                $('.custom-control-input').prop('checked', true);
            } else {
                $('.custom-control-input').prop('checked', false);
            } 
        });

        $(document).on('change', '#registration_page_id', function() {
            let registration_page_id = $(this).val();
            $.ajax({
                url:'{{route("registration-page-groups")}}',
                method:"get",
                data:{registration_page_id:registration_page_id},
                success:function(data)
                {
                    $('.groups-section').html(data);
                }
            });
        });
    </script>
@endpush --}}