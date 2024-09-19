@extends('layouts.app')
@section('content')
    <div class="containt-wrapper">
        <div class="d-flex flex-column w-tables rounded mt-3 bg-white" style="margin: 20px;">
            <div style="margin: 10px;">
                <a class="btn btn-success" href="{{route('campanas.index' , 1   )}}" >
                    Enviar campaña
                </a>
            </div>
            {!! $dataTable->table(['class' => 'table table-hover border-0']) !!}

        </div>
    </div>
    <style>
        .list_db{
            cursor:pointer;
            transition: all .300s   linear;
        }
        .list_db:hover{
            background: #f2f2f2;
        }
    </style>
@endsection
@push('scripts')
    @include('sections.datatable_js')

    <script>
        $('#assets-table').on('preXhr.dt', function (e, settings, data) {

            var asset_type = $('#asset_type').val();
            var user_id = $('#user_id').val();
            var status = $('#filter_status').val();
            var searchText = $('#search-text-field').val();
            data['asset_type'] = asset_type;
            data['user_id'] = user_id;
            data['status'] = status;
            data['searchText'] = searchText;
        });
        const showTable = () => {
            window.LaravelDataTables["assets-table"].draw(false);
        }

        $('#asset_type, #filter_status, #user_id, #search-text-field').on('change keyup',
            function () {
                if ($('#filter_status').val() != "all") {
                    $('#reset-filters').removeClass('d-none');
                    showTable();
                } else if ($('#user_id').val() != "all") {
                    $('#reset-filters').removeClass('d-none');
                    showTable();
                } else if ($('#asset_type').val() != "all") {
                    $('#reset-filters').removeClass('d-none');
                    showTable();
                } else if ($('#search-text-field').val() != "") {
                    $('#reset-filters').removeClass('d-none');
                    showTable();
                } else {
                    $('#reset-filters').addClass('d-none');
                    showTable();
                }
            });

        $('#reset-filters').click(function () {
            $('#filter-form')[0].reset();

            $('.filter-box .select-picker').selectpicker("refresh");
            $('#reset-filters').addClass('d-none');
            showTable();
        });

        $('body').on('click', '.delete-table-row', function () {
            var id = $(this).data('asset-id');
            Swal.fire({
                title: "@lang('messages.sweetAlertTitle')",
                text: "@lang('messages.recoverRecord')",
                icon: 'warning',
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: "@lang('messages.confirmDelete')",
                cancelButtonText: "@lang('app.cancel')",
                customClass: {
                    confirmButton: 'btn btn-primary mr-3',
                    cancelButton: 'btn btn-secondary'
                },
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('assets.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        blockUI: true,
                        data: {
                            '_token': token,
                            '_method': 'DELETE'
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                window.LaravelDataTables["assets-table"].draw(false);
                            }
                        }
                    });
                }
            });
        });

        $('body').on('click', '.lend', function () {
            let id = $(this).data('asset-id');
            let url = "{{ route('history.create', ':id') }}";
            url = url.replace(':id', id);
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        $('body').on('click', '.returnAsset', function () {
            let id = $(this).data('asset-id');
            let historyId = $(this).data('history-id');
            let url = "{{ route('assets.return', [':asset', ':history']) }}";
            url = url.replace(':asset', id);
            url = url.replace(':history', historyId);
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });
    </script>
@endpush