@extends('layouts.app')
@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@section('content')
    @php
        use Illuminate\Support\Facades\DB;
        use  Modules\Lubot\Http\Controllers\HelperController; 
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
                      <div class="card-header bg-white border-0 text-capitalize  pt-4"> 
                        <div class="card-header bg-white border-0 text-capitalize d-flex justify-content-between pt-4">
                            <h4 class="f-18 f-w-500 mb-0">
                                Información 
                            </h4>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">Nombre: </p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">{{$campana->nombre}}</p>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">Nombre del robot </p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">{{$campana->como_me_llamo}}</p>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">Frecuencia de envio </p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">{{$campana->frecuencia}}</p>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">Temporalidad</p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">{{$campana->temporalidad}}</p>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">Credito </p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">{{$campana->credito}}</p>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">Objetivo de lubot </p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">{{$objetivo->objetivos ?? 's'}}</p>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">Estado </p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">{{$campana->encendido === 0 ? "Apagado" : "Encendido" }}</p>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">tiutlo </p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">{{$campana->nombre}} </p>
                        </div>
                        @foreach ($segmentos as $segmento)
                            
                                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                                    <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                      Segmentos Id :
                                    </p>
                                    <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                        {{ $segmento->id }}
                                    </p>
                                </div>
                                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                                    <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                        Tipo de negocio :
                                    </p>
                                    <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                        {{ HelperController::con_tipo_negocio( $segmento->tipo_de_negocio , true)}}
                                      
                                    </p>
                                </div>
                                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                                    <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                        Barrio :
                                    </p>
                                    <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                      
                                        {{ HelperController::con_barrios( $segmento->barrio, true)}}
                                    </p>
                                </div>
                               
                                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                                    <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                        Ciudad :
                                    </p>
                                    <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                        
                                        {{ HelperController::con_ciudad(  $segmento->ciudad, true)}}
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
                           
                        @endforeach
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
                                {{ $campana->contador }}
                            </p>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                Estado del bot:
                            </p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap" id="campana_estado_encendido">
                                {{ $campana->encendido === 0 ? "Apagado" : 'Encendido' }}
                            </p>
                        </div>
                    </div>
                    <div class="container">
                        @if($campana->encendido === 0)
                     
                            <a href="{{route('reactivar' , $campana_id)}}" class="btn btn-success " id="reactivar_campana" style="margin: 10px; width:100%;">
                                Reactivar campaña
                            </a>
                        @else
                            Encendido
                        @endif
                       
                    </div>
                </div>
            </div>

        </div>



        <script>
             
              
        </script>
    @endif
    <div class="container-fluid"></div>
@endsection






<style>
   /* HTML: <div class="loader"></div> */
.loader {
  width: 100px;
  height: 50px;
  border-radius: 100px 100px 0 0;
  position: relative;
  overflow: hidden;
}
.loader:before {
  content: "";
  position: absolute;
  inset: 0 0 -100%;
  background: radial-gradient(farthest-side at top,#0000 35%,#aa47be,#039be6,#26c6dc,#459e44,#f9ec44,#f68524,#fa3536,#0000) bottom/100% 50% no-repeat;
  animation: l8 2s infinite;
}
@keyframes l8 {
  0%,20%   {transform: rotate(0)}
  40%,60%  {transform: rotate(.5turn)}
  80%,100% {transform: rotate(1turn)}
}
</style>
