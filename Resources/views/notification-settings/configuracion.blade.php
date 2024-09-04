@extends('layouts.app')



@section('content')
    <!-- SETTINGS START -->
    @include('lubot::css.css')
    <div class="w-100 d-flex ">

        <x-setting-sidebar :activeMenu="$activeSettingMenu" />

        <x-setting-card>
            <x-slot name="header">
                <div class="s-b-n-header" id="tabs">
                    <form action=""></form>
                    <nav class="tabs px-4 border-bottom-grey">
                        <div class="nav" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link f-15 zoom-setting active" id="configuracion" data-bs-toggle="tab"
                                data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                aria-selected="true">Configuracion</a>

                        </div>
                        <div class="s-b-n-content" style="padding-top: 100px">
                            <div class="tab-content tab-pane fade show " id="myTabContent">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <!-- Pestaña Home -->
                                    <div class="tab-pane fade show active" id="configuracion" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        
                                        <form id="lubotSettingsForm" action="{{ route('lubot.settings_store') }}"
                                            method="POST">
                                            @csrf
                                            <meta name="csrf-token" content="{{ csrf_token() }}">

                                            <div class="form-group">
                                                <label for="url_master">URL LUBOT MASTER API</label>
                                                <input id="url_master" type="text"
                                                    class="form-control height-35 f-14 w-500"
                                                    value="{{ $configuracion->LUBOT_MASTER_API ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="bearer_master">TOKEN</label>
                                                <input id="bearer_master" type="text"
                                                    class="form-control height-35 f-14 w-500"
                                                    value="{{ $configuracion->BEARER_LUBOT_MASTER ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="lubot_master">URL LUBOT</label>
                                                <input id="lubot_master" type="text"
                                                    class="form-control height-35 f-14 w-500"
                                                    value="{{ $configuracion->LUBOT_MASTER ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="webhook">URL WEBHOOK</label>
                                                <input id="webhook" type="text"
                                                    class="form-control height-35 f-14 w-500"
                                                    value="{{ $configuracion->NGROK_LUBOT_WEBHOOK ?? '' }}">
                                            </div>

                                            <button type="button" class="btn btn-danger" id="submitBtn">Guardar</button>


                                        </form>
                                        <h2 class="alert-success" style="font-size: 18px!important; padding:10px; display:none" id="msm_success">
                                            Actulizacion exitosa!
                                        </h2>
                                        <h2 class="alert-danger" style="font-size: 18px!important; padding:10px; display:none" id="msm_danger">
                                           Ocurrio un  problema!
                                        </h2>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </nav>
                </div>
            </x-slot>



        </x-setting-card>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const submitButton = document.getElementById('submitBtn');

                submitButton.addEventListener('click', function(e) {
                    e.preventDefault(); // Evitar el envío predeterminado del formulario
                    submitButton.innerHTML = "cargando..."
                    submitButton.disabled = true;
                    // Captura manualmente los valores de los campos del formulario
                    const urlMaster = document.getElementById('url_master').value;
                    const bearerMaster = document.getElementById('bearer_master').value;
                    const lubotMaster = document.getElementById('lubot_master').value;
                    const webhook = document.getElementById('webhook').value;

                    // Construir el objeto que vamos a enviar
                    const data = {
                        url_master: urlMaster,
                        BEARER_LUBOT_MASTER: bearerMaster,
                        LUBOT_MASTER: lubotMaster,
                        NGROK_LUBOT_WEBHOOK: webhook
                    };

                    fetch("{{ route('lubot.settings_store') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content') // Token CSRF
                            },
                            body: JSON.stringify(data) // Enviar los datos como JSON
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data)
                            if (data.success === 200) {
                                msm_success.style.display='grid'
                            }
                           
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error al enviar la solicitud');
                            msm_danger.display='grid'
                        })
                        .finally(function() {
                            submitButton.innerHTML = "Guardar"
                            submitButton.disabled = false;
                        })
                });
            });
        </script>
    </div>
    <!-- SETTINGS END -->
@endsection
<style>
    .w-500 {
        width: 500px !important;
    }
</style>
