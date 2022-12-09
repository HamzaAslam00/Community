@extends('layouts.app')

@section('title', '| Groups')

@section('content')
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Groups List</h3>
                    <div class="nk-block-des text-soft">
                        <p>You have total {{ $groups_count }} Groups.</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li class="nk-block-tools-opt"><a href="#" class="btn btn-primary btn-sm" data-act="ajax-modal" data-method="get" data-action-url="{{ route('groups.create') }}" data-title="Add New Group"><em class="icon ni ni-plus"></em><span>Add Group</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-preview">
            <div class="card-inner">
                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false" id="groups_table">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col text-left"><span class="sub-text">ID</span></th>
                            <th class="nk-tb-col"><span class="sub-text">Name</span></th>
                            <th class="nk-tb-col"><span class="sub-text">Description</span></th>
                            <th class="nk-tb-col"><span class="sub-text">Status</span></th>
                            <th class="nk-tb-col tb-col-mb text-right"><span class="sub-text">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            options = {
                responsive: {
                    details: true
                },
                ajax: '{{ route('groups-datatable') }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: true,
                columnDefs: [
                    { width: 1, targets: 4 },
                    { width: '5%', targets: 0 }
                ],
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
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