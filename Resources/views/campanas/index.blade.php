@extends('layouts.app')
@section('content')
    @if (in_array('admin', user_roles()))
        <div class="content-wrapper">
            <form action="{{ route('campanas.stores') }}" method="POST">
                @csrf
                @method('POST')
                <div class="d-flex flex-column w-tables rounded mt-3 bg-white" style="padding: 10px;">
                    <div class=" container">
                        <div class="col-md-12">
                            <x-forms.text class="mr-0 mr-lg-2 mr-md-2" fieldLabel="Nombre de la campana"
                                fieldPlaceholder="Nombre de la campana" fieldName="nombre_campanas" fieldRequired="true"
                                fieldId="contract_prefix" fieldValue="" />
                        </div>
                        <div class="col-md-12">
                            <x-forms.select fieldId="remind_type" fieldLabel="Objetivo de lubot" fieldName="objetivo"
                                search="true">
                                @foreach ($objetivos as $objetivo)
                                    <option value="{{ $objetivo->objetivos }}">{{ $objetivo->objetivos }}</option>
                                @endforeach

                            </x-forms.select>
                        </div>

                        <div class="col-md-12">
                            <x-forms.select fieldId="mode" fieldLabel="Modo del bot" fieldName="mode" search="true">
                                <option value="1">Propm</option>
                                <option selected value="2" selected>Saludo generico</option>
                            </x-forms.select>
                        </div>

                    </div>


                    <div class="container" id="con_propm" style="margin-top:40px; display:none; ">
                        <div id="form-container">
                            <div class="row container mb-2 form-row">
                                <div class="col-md-5">
                                    <label for="">
                                        Si el cliente dice: <span style="color: brown">*</span>
                                    </label>
                                    <input type="text" class="form-control _promp" placeholder="Pregunta"
                                        name="pregunta[]">
                                </div>
                                <div class="col-md-5">
                                    <label for="">
                                        lubot debería responder: <span style="color: brown">*</span>
                                    </label>
                                    <input type="text" class="form-control _promp" placeholder="Respuesta"
                                        name="respuesta[]">
                                </div>
                                <div class="promps_btn col-md-2">
                                    <button class="btn " type="button" onclick="addForm(this)">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="container">

                        <div id="input-container">
                            <div class="input-row row">
                                <div class="col-md-2 ">
                                    <select name="pais[]" class="form-control selectpicker" data-live-search="true">
                                        @foreach ($paises as $pais)
                                            <option value="{{ $pais['id'] }}">{{ $pais['nombre'] }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="ciudad[]" class="form-control selectpicker">
                                        @foreach ($ciudades as $ciudad)
                                            <option value="{{ $ciudad['id'] }}">{{ $ciudad['nombre'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="barrio[]" class="form-control selectpicker">
                                        @foreach ($barrios as $barrio)
                                            <option value="{{ $barrio['id'] }}">{{ $barrio['nombre'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="segmento[]" class="form-control selectpicker">
                                        @foreach ($segmentos as $segmento)
                                            <option value="{{ $segmento['id'] }}">{{ $segmento['nombre'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Cantidad" name="cantidad[]">
                                </div>
                                <div class="col-md-2" style="position:relative; right: -40px;">
                                    <button class="btn" type="button" onclick="addRow()">
                                        +
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="container" style="margin-top:30px ">
                        <button class="btn btn-success" style="width: 100%;">
                            Registrar campaña
                        </button>
                    </div>


                </div>
        </div>



        <script>
            mode.addEventListener("change", function(e) {
                console.log(e.target.value)
                if (e.target.value == 2) {
                    con_propm.style.display = "none";
                }

                if (e.target.value == 1) {
                    con_propm.style.display = "grid";
                    document.querySelectorAll("._promp").forEach(element => {
                        element.required = true;
                    });

                }
            })

            function addRow(button) {
                // Definir la nueva fila con literales de plantilla
                var newRow = `
                        <div class="input-row row" style='margin-top:10px;'>
                              <div class="col-md-2">
                                    <select name="pais[]" class="form-control selectpicker" data-live-search="true">
                                        @foreach ($paises as $pais)
                                            <option value="{{ $pais['id'] }}">{{ $pais['nombre'] }}</option>
                                        @endforeach                      
                                  </select>
                             </div>
                            <div class="col-md-2">
                                <select name="ciudad[]" class="form-control selectpicker" data-live-search="true">
                                         @foreach ($ciudades as $ciudad)
                                               <option value="{{ $ciudad['id'] }}">{{ $ciudad['nombre'] }}</option>
                                          @endforeach                  
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="barrio[]" class="form-control selectpicker" data-live-search="true">
                                        @foreach ($barrios as $barrio)
                                            <option value="{{ $barrio['id'] }}">{{ $barrio['nombre'] }}</option>
                                         @endforeach
                                </select>
                            </div>
                             <div class="col-md-2">
                                <select name="segmento[]" class="form-control selectpicker" data-live-search="true">
                                    @foreach ($segmentos as $segmento)
                                       <option value="{{ $segmento['id'] }}">{{ $segmento['nombre'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" placeholder="Cantidad" name="cantidad[]">
                            </div>
                            <div class="col-md-2" style="position:relative; right: -40px;">
                                <button class="btn " type="button" onclick="removeRow(this)">-</button>
                                <button class="btn " type="button" onclick="addRow(this)">+</button>
                            </div>
                        </div>`;

                // Añadir la nueva fila al contenedor
                $('#input-container').append(newRow);

                // Inicializar los selectpicker en la nueva fila
                $('.selectpicker').selectpicker('refresh');

                // Quitar el botón de agregar de la fila anterior
                $(button).remove();
            }

            function removeRow(button) {
                // Eliminar la fila correspondiente
                $(button).closest('.input-row').remove();

                // Asegurar que siempre haya un botón de agregar en la última fila
                var lastRow = $('#input-container .input-row:last');
                if (!lastRow.find('.btn-success').length) {
                    lastRow.find('.col-md-1').append(
                        '<button class="btn btn-success" type="button" onclick="addRow(this)">+</button>');
                }
            }

            $(document).ready(function() {
                // Inicializar selectpicker en la fila existente
                $('.selectpicker').selectpicker();
            });


            function addForm(button) {
                // Definir la nueva fila con literales de plantilla
                var newForm = `
                            <div class="row container mb-2 form-row" style="margin-top:10px;">
                                <div class="col-md-5">
                                    <label for="">
                                        Si el cliente dice: <span style="color: brown">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Pregunta" name="pregunta[]" required>
                                </div>
                                <div class="col-md-5">
                                    <label for="">
                                        lubot debería responder: <span style="color: brown">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Respuesta" name="respuesta[]" required>
                                </div>
                                <div class="promps_btn">
                                    <button class="btn" type="button" onclick="removeForm(this)">-</button>
                                    <button class="btn " type="button" onclick="addForm(this)">+</button>
                                </div>
                            </div>`;

                // Añadir la nueva fila al contenedor
                $('#form-container').append(newForm);

                // Eliminar el botón de agregar de la fila anterior
                $(button).remove();
            }

            function removeForm(button) {
                // Eliminar la fila correspondiente
                $(button).closest('.form-row').remove();

                // Asegurar que siempre haya un botón de agregar en la última fila
                var lastRow = $('#form-container .form-row:last');
                if (!lastRow.find('.btn-success').length) {
                    lastRow.find('.promps_btn').append(
                        '<button class="btn btn-success" type="button" onclick="addForm(this)">+</button>');
                }
            }
        </script>

        <style>
            .input-row {
                padding: 0 !important;
                margin-top: 30px;
                width: 100%;

            }

            .input-row input {
                height: 40px !important;
            }


            select {
                position: absolute !important;
                bottom: 0;
                left: 50%;
                display: block !important;
                width: 0.5px !important;
                height: 100% !important;
                padding: 0 !important;
                opacity: 0 !important;
                border: none;
                z-index: 0 !important;
            }

            input {
                margin-right: 10px;
                height: 50px !important;
                border: solid 1px rgba(0, 0, 0, .5) !important;
                padding: 10px !important;
                border-radius: 5px;
            }

            .input-row input {
                margin-right: 10px;
                width: 200px !important;
                border: solid 1px rgba(0, 0, 0, .5) !important;
                padding: 10px;
                border-radius: 5px;
            }

            .input-row button {
                margin-left: 10px;

            }

            .promps_btn {
                position: relative;
                bottom: -30px;
                height: 40px;
                width: 50px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        </style>
        </div>
    @endif
    <div class="container-fluid"></div>
@endsection
