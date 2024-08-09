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
                                        {{ $segmento->tipo_de_negocio }}
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
                                {{ $campana->contador }}
                            </p>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize">
                                Estado del bot:
                            </p>
                            <p class="mb-0 text-dark-grey f-14 w-70 text-wrap" id="campana_estado_encendido">

                            </p>
                        </div>
                        <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                            <div class="loader" style="display: none" id="loader_spiner">
                                
                            </div>
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
                let campana_estado_url = `{{ $campana_estado }}`
                verificar_actividad()

                function verificar_actividad() {

                    // Intervalo en milisegundos para hacer polling (ejemplo: cada 5 segundos)
                    const intervalo = 1000;

                    // Función para verificar el estado
                    function comprobarEstado() {
                        fetch(campana_estado_url)
                            .then(response => response.json())
                            .then(data => {
                                if (data.encendido === 0) {
                                    // Detener el polling si el estado es 0
                                    loader_spiner.style.display = "none"
                                    clearInterval(intervalId);
                                    console.log('El encendido es 0, se ha detenido el polling.');
                                    campana_estado_encendido.innerHTML = `
                                         <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#5f6a6a"
                                        class="bi bi-lightbulb-off-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2 6c0-.572.08-1.125.23-1.65l8.558 8.559A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m10.303 4.181L3.818 1.697a6 6 0 0 1 8.484 8.484zM5 14.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5M2.354 1.646a.5.5 0 1 0-.708.708l12 12a.5.5 0 0 0 .708-.708z" />
                                    </svg>
                                    `
                                } else {
                                    console.log('El encendido es 1, continúo con el polling.');
                                    loader_spiner.style.display = "flex"
                                    campana_estado_encendido.innerHTML = `
                                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#186a3b"
                                        class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5" />
                                    </svg>
                                    `
                                }
                            })
                            .catch(error => {
                                console.error('Error al realizar la solicitud:', error);
                            });
                    }

                    // Comenzar el polling
                    const intervalId = setInterval(comprobarEstado, intervalo);
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
