<div class="nk-block-head">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">Tickets List</h5>
        </div>
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu">
                    <em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                            <a href="#" class="btn btn-primary btn-sm" data-act="ajax-modal" data-method="get"
                                data-action-url="{{ route('admin.registration-pages.tickets.create', $registrationPage->id) }}"
                                data-title="Add New Ticket">
                                <em class="icon ni ni-plus"></em>
                                <span>Add Ticket</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false" id="tickets_table"
    style="width: 100%">
    <thead>
        <tr class="nk-tb-item nk-tb-head">
            <th class="nk-tb-col text-left"><span class="sub-text">ID</span></th>
            <th class="nk-tb-col"><span class="sub-text">Title</span></th>
            <th class="nk-tb-col"><span class="sub-text">Amount</span></th>
            <th class="nk-tb-col"><span class="sub-text">Status</span></th>
            <th class="nk-tb-col tb-col-mb text-right"><span class="sub-text">Actions</span></th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

@push('scripts')
<script>
    $(function() {
            options = {
                responsive: {
                    details: true
                },
                ajax: '{{ route('admin.registration-pages.tickets-datatable', $registrationPage->id) }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: true,
                columnDefs: [
                    { width: 1, targets: 3 },
                    { width: '5%', targets: 0 }
                ],
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'amount', name: 'amount'},
                    {data: 'status', name: 'status'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).addClass('nk-tb-item');
                    $('td', row).addClass('nk-tb-col nk-tb-col-tools');
                },
            }
            NioApp.DataTable.init(options);
        });
</script>
@endpush