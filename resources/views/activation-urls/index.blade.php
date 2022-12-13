@extends('layouts.app')

@section('title', '| ActivationUrls')

@section('content')
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">ActivationUrls List</h3>
                    <div class="nk-block-des text-soft">
                        <p>You have total {{ $activationUrlsCount }} ActivationUrls.</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li class="nk-block-tools-opt"><a href="{{ route('activation-urls.create') }}" class="btn btn-primary btn-sm"><em class="icon ni ni-plus"></em><span>Generate Url</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-preview">
            <div class="card-inner">
                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false" id="activation_urls_table">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col text-left"><span class="sub-text">ID</span></th>
                            <th class="nk-tb-col"><span class="sub-text">Title</span></th>
                            <th class="nk-tb-col"><span class="sub-text">Ticket</span></th>
                            <th class="nk-tb-col"><span class="sub-text">URL</span></th>
                            <th class="nk-tb-col"><span class="sub-text">User Name</span></th>
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
                ajax: '{{ route('activation-urls-datatable') }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: true,
                columnDefs: [
                    { width: 1, targets: 5 },
                    { width: '5%', targets: 0 }
                ],
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'ticket', name: 'ticket'},
                    {data: 'url', name: 'url'},
                    {data: 'user', name: 'user'},
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