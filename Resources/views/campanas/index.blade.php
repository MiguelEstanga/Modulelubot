@extends('layouts.app')
@section('content')
@include('lubot::css.css')
    <div class="content-wrapper  ">
        <div class="helper_container">
            @include('lubot::component.vamos-hacer-magia-juntos')
        </div>
       <div>
        @include("lubot::campanas.components.formulario")
       </div>
        
    </div>



    <!--script>
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
                                                           
                                  </select>
                             </div>
                            <div class="col-md-2">
                                <select name="ciudad[]" class="form-control selectpicker" data-live-search="true">
                                                         
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="barrio[]" class="form-control selectpicker" data-live-search="true">
                                       
                                </select>
                            </div>
                             <div class="col-md-2">
                                <select name="segmento[]" class="form-control selectpicker" data-live-search="true">
                                  
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
    </script-->

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
@endsection
