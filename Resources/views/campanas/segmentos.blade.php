
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
@if(in_array('admin', user_roles()))

<div class="content-wrapper" >
    <div class="d-flex flex-column w-tables rounded mt-3 bg-white" style="padding: 10px;">   
        {{$campana->nombre}}
    </div>      
     <div class="d-flex flex-column w-tables rounded mt-3 bg-white" style="padding: 10px;">   
         {{$dataTable->table(['class' => 'table table-hover border-0 w-100'])}}
     </div>        
 </div>
         
     

<script>
     document.addEventListener("DOMContentLoaded", (event) => {
         let url = `{{route('cambiar.estado' , '*')}}`;
         let ulr_parse = url.split('*')[0]
        
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
     console.log( document.querySelectorAll('.activate_campaigns'))
     console.log('s')
     $('.activate_campaigns').on('change' , function(){
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
     const estado  = (element) => {
         console.log(element.id)
         let url = `{{route('cambiar.estado' , '*')}}`;
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
 .{
     margin-left: 270;
 }
</style>