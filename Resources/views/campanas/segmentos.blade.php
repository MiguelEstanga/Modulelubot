@extends('layouts.app')
@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@section('content')
    @php
        use Illuminate\Support\Facades\DB;

        function getPrompt($id)
        {
            $prompt = DB::table('prompts')->where('id_campanas', $id)->first();
            return DB::table('prompts')->where('id_campanas', $id)->first()->prompt ?? $id;
            return $prompt->prompts ?? 'null'; // Handle case where no record is found
        }
    @endphp
    @if (in_array('admin', user_roles()))
        <div class="content-wrapper">
            <div class="d-flex flex-column w-tables rounded mt-3 bg-white" style="padding: 10px;">
                Campaña : {{ $campana->nombre }}
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="d-flex flex-column w-tables rounded mt-3 bg-white" style="padding: 10px; ">
                        <div class="card-header bg-white border-0 text-capitalize d-flex justify-content-between pt-4">
                            <h4 class="f-18 f-w-500 mb-0">
                                Información de la campaña
                            </h4>
                        </div>
                        @foreach ($segmentos as $segmento)
                            <div class="card-header bg-white border-0 text-capitalize  pt-4">
                                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                                    <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                        Id :
                                    </p>
                                    <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                        {{ $segmento->id }}
                                    </p>
                                </div>
                                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                                    <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                        Segmento :
                                    </p>
                                    <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                        {{ $segmento->segmento }}
                                    </p>
                                </div>
                                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                                    <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                        Barrio :
                                    </p>
                                    <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                        {{ $segmento->barrio }}
                                    </p>
                                </div>
                                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                                    <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                        Barrio :
                                    </p>
                                    <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                        {{ $segmento->pais }}
                                    </p>
                                </div>
                                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                                    <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                        Ciudad :
                                    </p>
                                    <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                        {{ $segmento->ciudad }}
                                    </p>
                                </div>
                                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                                    <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                        Cantidad :
                                    </p>
                                    <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                        {{ $segmento->cantidad }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                        <div class="container">
                            <button class="btn btn-danger">
                                Eliminar
                            </button>
                        </div>

                    </div>

                </div>
                <div class="col-md-4 d-flex flex-column w-tables rounded mt-3 bg-white" style="padding: 10px;">
                    <div class="" style="width: 100%!important;">
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                Negocios encontrados:
                            </p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                0
                            </p>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                               Cantidad de activación:
                            </p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                               {{$campana->contador}}
                            </p>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                Estado del bot:
                            </p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                @if ($campana->encendido === 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#5f6a6a"
                                        class="bi bi-lightbulb-off-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2 6c0-.572.08-1.125.23-1.65l8.558 8.559A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m10.303 4.181L3.818 1.697a6 6 0 0 1 8.484 8.484zM5 14.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5M2.354 1.646a.5.5 0 1 0-.708.708l12 12a.5.5 0 0 0 .708-.708z" />
                                    </svg>
                                @elseif($campana->encendido === 1)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#186a3b"
                                        class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5" />
                                    </svg>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="container">
                        <button class="btn btn-success " id="reactivar_campana" style="margin: 10px; width:100%;">
                            Reactivar campaña
                        </button>
                    </div>
                </div>
            </div>

        </div>



        <script>
            document.addEventListener("DOMContentLoaded", (event) => {
                let url = `{{ route('cambiar.estado', '*') }}`;
                let ulr_parse = url.split('*')[0]

                let id_companie = {{ $id_companie }}
                let id_campana = {{ $campana->id }}
                let url_bot_campana = `{{ $url_activar_bot }}`
                let url_bot_campana_parse = `${url_bot_campana}/${id_companie}/${id_campana}/${id_companie}`
                let campana_estado_url = `{{$campana_estado}}`
                verificar_actividad()

                function verificar_actividad() {
                    alert(campana_estado)
                    fetch(campana_estado_url)
                    .then(response => response.json())
                    .then(response => console.log(response))
                }
                reactivar_campana.addEventListener("click", () => {
                    reactivar_campana.innerText = "iniciando..."
                    fetch(url_bot_campana_parse, {
                            headers: {
                                'ngrok-skip-browser-warning': 'true'
                            }
                        })
                        .then(response => response.json())
                        .then(res => {

                            console.log(res)
                        })
                        .finally(() => {
                            reactivar_campana.innerText = "Reactivar campaña"
                        })
                })

                document.querySelectorAll('.activar_estado').forEach(element => {
                    element.addEventListener('change', function(e) {
                        fetch(`${ulr_parse}${e.target.name}`)
                            .then(res => res.json())
                            .then(data => {
                                window.location.reload();
                            })
                        //alert(e.target.name)
                    })
                });

            })
        </script>
    @endif
    <div class="container-fluid"></div>
@endsection





@push('scripts')
    @include('sections.datatable_js')

    <script>
        const showTable = () => {
            window.LaravelDataTables["orders-table"].draw(false);
        }
        console.log(document.querySelectorAll('.activate_campaigns'))
        console.log('s')
        $('.activate_campaigns').on('change', function() {
            console.log('s')
        })

        $('#orders-table').on('change', '.order-status', function() {
            var id = $(this).data('order-id');
            var status = $(this).val();

            changeOrderStatus(id, status);
        });





        $('#search-text-field').on('keyup', function() {
            if ($('#search-text-field').val() != "") {
                $('#reset-filters').removeClass('d-none');
                showTable();
            }
        });

        $('#reset-filters,#reset-filters-2').click(function() {
            $('#filter-form')[0].reset();

            $('.filter-box .select-picker').selectpicker("refresh");
            $('#reset-filters').addClass('d-none');
            showTable();
        });

        $('#quick-action-type').change(function() {
            const actionValue = $(this).val();
            if (actionValue != '') {
                $('#quick-action-apply').removeAttr('disabled');

                if (actionValue == 'change-status') {
                    $('.quick-action-field').addClass('d-none');
                    $('#change-status-action').removeClass('d-none');
                } else {
                    $('.quick-action-field').addClass('d-none');
                }
            } else {
                $('#quick-action-apply').attr('disabled', true);
                $('.quick-action-field').addClass('d-none');
            }
        });

        $('#quick-action-apply').click(function() {
            const actionValue = $('#quick-action-type').val();
            if (actionValue == 'delete') {
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
                        applyQuickAction();
                    }
                });

            } else {
                applyQuickAction();
            }
        });

        $('body').on('click', '.delete-table-row', function() {
            var id = $(this).data('order-id');
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
                    var url = "{{ route('orders.destroy', ':id') }}";
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
                        success: function(response) {
                            if (response.status == "success") {
                                showTable();
                            }
                        }
                    });
                }
            });
        });

        $('body').on('click', '.unpaidAndPartialPaidCreditNote', function() {
            var id = $(this).data('invoice-id');

            Swal.fire({
                title: "@lang('messages.confirmation.createCreditNotes')",
                text: "@lang('messages.creditText')",
                icon: 'warning',
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: "@lang('app.yes')",
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
                    var url = "{{ route('creditnotes.create') }}?invoice=:id";
                    url = url.replace(':id', id);

                    location.href = url;
                }
            });
        });
        const estado = (element) => {
            console.log(element.id)
            let url = `{{ route('cambiar.estado', '*') }}`;
            let ulr_parse = url.split('*')[0]
            element.addEventListener('change', function(e) {
                fetch(`${ulr_parse}${element.id}`)
                    .then(res => res.json())
                    .then(data => {
                        window.location.reload();
                    })
                //alert(e.target.name)
            })

        }
        const applyQuickAction = () => {
            var rowdIds = $("#invoices-table input:checkbox:checked").map(function() {
                return $(this).val();
            }).get();

            var url = "{{ route('invoices.apply_quick_action') }}?row_ids=" + rowdIds;

            $.easyAjax({
                url: url,
                container: '#quick-action-form',
                type: "POST",
                disableButton: true,
                buttonSelector: "#quick-action-apply",
                data: $('#quick-action-form').serialize(),
                blockUI: true,
                success: function(response) {
                    if (response.status == 'success') {
                        showTable();
                        resetActionButtons();
                    }
                }
            })
        };
    </script>
@endpush
<style>
    . {
        margin-left: 270;
    }
</style>
