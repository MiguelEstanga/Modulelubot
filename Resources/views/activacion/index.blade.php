@extends('layouts.app')



@section('content')
   @if(in_array('admin', user_roles()))
   <div class="w-100 d-flex ">

    @include('lubot::component.menu-configuracion-lubot')

    <x-setting-card>
        <x-slot name="header">
            <div class="s-b-n-header" id="tabs">
                <h2 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    Activacion
                  
                    @if($activacion === true)
                        Activo
                    @else
                       Desactivado
                    @endif
            </h2>
            </div>
        </x-slot>
        <x-slot name="action">
         
                <div class="row p-20 container" >
                    <form action="{{route('lubot.activacion')}}" method="post" class=""  autocomplete="on">
                         
                           @csrf
                            @method("post")
                           <div class="col-lg-12">
                                <x-forms.text class="mr-0 mr-lg-2 mr-md-2" fieldLabel="Numero de telefono" fieldPlaceholder="Numero de telefono" fieldName="numero"
                                fieldRequired="true" fieldId="contract_prefix" :fieldValue="$numero" />
                               
                          
                           </div>
                           
                           <div class="container">
                             <button class="btn btn-success">
                                @if($activacion === true)
                                    Actulizar datos
                                @else
                                    Activar 
                                @endif
                             </button>
                           </div>
                    </form>
                </div>
            <!-- Buttons End -->
        </x-slot>

    </x-setting-card>

</div>
 @endif
    <div class="container-fluid"></div>
@endsection
<style>
    
</style>


