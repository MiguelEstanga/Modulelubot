@extends('layouts.app')
@section('content')
    @if(in_array('admin', user_roles()))
        <div class="content-wrapper" style="width: 70vw;">
            <div class="d-flex  ">

                @include('lubot::component.menu-configuracion-lubot')
                <x-setting-card>
                    <div class="container">
                        <x-slot name="header">
                            <div class="s-b-n-header" id="tabs">
                                <h2 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                                    seleccion de semento    
                                   
                                </h2>
                            </div>
                        </x-slot>
                    </div>
                 
                    <div class="container">
                      
                        <x-slot name="action">
                            <div class="" style="border-radius: 10px; box-shadow:10px rgba(0,0,0,..5); padding:10px;" >
                                <form action="{{route('campanas.stores')}}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="row">   
                                        <div class="col-md-6">
                                            <x-forms.text class="mr-0 mr-lg-2 mr-md-2" fieldLabel="Nombre de la campana" fieldPlaceholder="Nombre de la campana" fieldName="nombre_campanas"
                                            fieldRequired="true" fieldId="contract_prefix" fieldValue="" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-forms.select fieldId="remind_type" fieldLabel="Objetivo de lubot" fieldName="remind_type"
                                            search="true">
                                                <option value="">Selecciona un objetivo</option>
                                            </x-forms.select>
                                        </div>
                                       
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <x-forms.select fieldId="mode" fieldLabel="Modo" fieldName="mode"
                                            search="true">
                                            <option value="1">Propm</option>
                                            <option selected value="2">Saludo generico</option>
                                        </x-forms.select>
                                        </div>
                                    </div>
                                   
                                    
                                    <div class="container row" id="con_propm">
                                        <div class="container col-md-12">
                                            
                                            <div class="container">
                                                <hr>
                                                <h2 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">Seccion de propmps</h2>
                                                <div id="form-container"  >
                                                    <div class="row container mb-2">
                                                        <div class="col-md-5">
                                                            <label for="">
                                                                Si el cliente dice: <span style="color: brown">*</span>
                                                            </label>
                                                            <input type="text" class="form-control" placeholder="Pregunta" name="pregunta[]" required>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label for="">
                                                                lubot debria responder: <span style="color: brown">*</span>
                                                            </label>
                                                            <input type="text" class="form-control" placeholder="Respuesta" name="respuesta[]" required>
                                                        </div>
                                                        <div class="promps_btn" >
                                                            <button class="btn btn-success" type="button" onclick="addForm()">
                                                                +
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                        </div>
                                    </div>
                                  
                                    <!--div class="container row">
                                        <div class="col-md-6" style="margin-top: 20px;">
                                            <x-forms.select fieldId="remind_type" fieldLabel="Paquete" fieldName="paqute"
                                            search="true">
                                                 <option value="">Paquete de 30 msj</option>
                                            </x-forms.select>
                                           
                                        </div>
                                       
                                        <div class="row col-md-6" style="width: 300px;margin-top:30px;">
                                              <div class="col-md-6 form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                <div 
                                                    style=" margin:5px 0 0 4px;  padding: :0 0 0 15px;"
                                                >
                                                    <p>Si</p>
                                                </div>
                                              
                                              </div>
                                              <div class="col-md-6 form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                                <div 
                                                    style=" margin:5px 0 0 4px;  padding: :0 0 0 10px;"
                                                >
                                                    <p>No</p>
                                                </div>
                                              </div>
                                        </div>
                                    </div -->
                                    <div class="container">
                                        <h2 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                                            Segmentos
                                        </h2>
                                        <div id="input-container">
                                            <div class="input-row">
                                               
                                                    <div class="col-md-2">
                                                        <x-forms.select fieldId="remind_type" fieldLabel="pais" fieldName="pais[]"
                                                        search="true">
                                                        <option value="1">Colombia</option>
                                                             </x-forms.select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <x-forms.select 
                                                            fieldId="remind_type" 
                                                            fieldLabel="ciudad" 
                                                            fieldName="ciudad[]"
                                                            search="true">
                                                            <option value="1">bogota</option>
                                                            <option value="2">Medallin</option>
                                                            <option value="3">Cali</option>
                                                            <option value="4">Barranquilla</option>
                                                        </x-forms.select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <x-forms.select 
                                                        fieldId="remind_type" 
                                                        fieldLabel="barrio" 
                                                        fieldName="barrio[]"
                                                        search="true">
                                                        <option value="1">Marsella</option>
                                                        <option value="2">Villa Alsacia</option>
                                                        <option value="3">Las Dos Avenidas</option>
                                                        <option value="4">El Nogal</option>
                                                        </x-forms.select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <x-forms.select 
                                                        fieldId="remind_type" 
                                                       
                                                        fieldName="segmento[]"
                                                        search="true">
                                                        <option value="1">ferreteria</option>
                                                        <option value="2">suministros para odontologia</option>
                                                        <option value="3">odontologo</option>
                                                        <option value="4">constructora</option>
                                                         </x-forms.select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <x-forms.text class="mr-0 mr-lg-2 mr-md-2" fieldPlaceholder="Cantidad" fieldLabel="" fieldName="cantidad"
                                                         fieldRequired="true" fieldId="contract_prefix" fieldValue="" />
                                                    </div>
                                                    <div class="col-md-3" style="position: relative; bottom:-45px">  
                                                        <button class="btn btn-success" type="button" onclick="addRow(this)">+</button>
                                                    </div>
                                                   
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="container">
                                        <button class="btn btn-success">
                                            Registrar Campaña
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </x-slot>
                    </div>
                    
                </x-setting-card>
        
            </div>
            <script>
                const limit = 30;
                document.getElementById('con_propm').style.display = 'none';
                document.addEventListener("DOMContentLoaded", (event) => {
                    document.getElementById('mode').addEventListener('change', function(e) {
                        if (this.value == '2') {
                            document.getElementById('con_propm').style.display = 'none';
                        }
                        if (this.value == '1') {
                            document.getElementById('con_propm').style.display = 'grid';
                        }
                    })
                    window.addRow = function(button) {
                        if (getTotal() >= limit) {
                            alert('El límite ha sido alcanzado.');
                            return;
                        }
            
                        const container = document.getElementById('input-container');
                        const newRow = document.createElement('div');
                        newRow.classList.add('input-row');
            
                        newRow.innerHTML = `
                            <div class="col-md-2">
                                                        <x-forms.select fieldId="remind_type" fieldLabel="pais" fieldName="pais[]"
                                                        search="true">
                                                        <option value="1">Colombia</option>
                                                             </x-forms.select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <x-forms.select 
                                                            fieldId="remind_type" 
                                                            fieldLabel="ciudad" 
                                                            fieldName="ciudad[]"
                                                            search="true">
                                                            <option value="1">bogota</option>
                                                            <option value="2">Medallin</option>
                                                            <option value="3">Cali</option>
                                                            <option value="4">Barranquilla</option>
                                                        </x-forms.select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <x-forms.select 
                                                        fieldId="remind_type" 
                                                        fieldLabel="barrio" 
                                                        fieldName="barrio[]"
                                                        search="true">
                                                        <option value="1">Marsella</option>
                                                        <option value="2">Villa Alsacia</option>
                                                        <option value="3">Las Dos Avenidas</option>
                                                        <option value="4">El Nogal</option>
                                                        </x-forms.select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <x-forms.select 
                                                        fieldId="remind_type" 
                                                       
                                                        fieldName="segmento[]"
                                                        search="true">
                                                        <option value="1">ferreteria</option>
                                                        <option value="2">suministros para odontologia</option>
                                                        <option value="3">odontologo</option>
                                                        <option value="4">constructora</option>
                                                         </x-forms.select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <x-forms.text class="mr-0 mr-lg-2 mr-md-2" fieldPlaceholder="Cantidad" fieldLabel="" fieldName="cantidad"
                                                         fieldRequired="true" fieldId="contract_prefix" fieldValue="" />
                                                    </div>
                                    <button class="btn btn-success" type="button" onclick="addRow(this)">+</button>
                                    <button class="btn btn-danger" type="button" onclick="deleteRow(this)">X</button>
                        `;
            
                        // Append the new row
                        container.appendChild(newRow);
            
                        // Remove the add button from the previous row
                        const previousRow = button.parentNode;
                        const previousAddButton = previousRow.querySelector('button[onclick="addRow(this)"]');
                        previousAddButton.style.display = 'none';
            
                        // Show the delete button on the previous row
                        const previousDeleteButton = previousRow.querySelector('button[onclick="deleteRow(this)"]');
                        if (previousDeleteButton) {
                            previousDeleteButton.style.display = 'inline-block';
                        }
            
                        // Update the total and check limit
                        updateTotal();
                    }
            
                    window.deleteRow = function(button) {
                        const row = button.parentNode;
                        const container = document.getElementById('input-container');
            
                        // Remove the row
                        container.removeChild(row);
            
                        // If this is the last row, show the add button on the previous row
                        const lastRow = container.lastElementChild;
                        if (lastRow) {
                            const addButton = lastRow.querySelector('button[onclick="addRow(this)"]');
                            addButton.style.display = 'inline-block';
                        }
            
                        // Update the total and check limit
                        updateTotal();
                    }
            
                    window.adjustValue = function(input) {
                        const currentTotal = getTotal() - (parseInt(input.value) || 0);
                        const value = parseInt(input.value) || 0;
                        const newTotal = currentTotal + value;
            
                        if (newTotal > limit) {
                            input.value = limit - currentTotal;
                            alert('El valor máximo permitido ha sido ajustado.');
                        }
            
                        updateTotal();
                    }
            
                    window.updateTotal = function() {
                        const total = getTotal();
                        const addButton = document.querySelector('.input-row:last-child button[onclick="addRow(this)"]');
            
                        if (total >= limit && addButton) {
                            addButton.disabled = true;
                        } else if (addButton) {
                            addButton.disabled = false;
                        }
                    }
            
                    function getTotal() {
                        const inputs = document.querySelectorAll('input[name="cantidad[]"]');
                        let total = 0;
            
                        inputs.forEach(input => {
                            total += parseInt(input.value) || 0;
                        });
            
                        return total;
                    }
                });
                function addForm() {
                        // Obtener el contenedor del formulario
                        var container = document.getElementById('form-container');
                        // Clonar el primer formulario dentro del contenedor
                        var originalForm = container.children[0];
                        var newForm = originalForm.cloneNode(true);
                        
                        // Resetear los valores de los inputs en el formulario clonado
                        var inputs = newForm.getElementsByTagName('input');
                        for (var i = 0; i < inputs.length; i++) {
                            inputs[i].value = '';
                        }
                        
                        // Añadir el botón de eliminación
                        var removeButton = document.createElement('button');
                        removeButton.className = 'btn btn-danger promps_btn';
                        removeButton.textContent = '-';
                        removeButton.onclick = function() {
                            container.removeChild(newForm);
                        };
                        
                        // Añadir el botón de eliminación al nuevo formulario
                        newForm.appendChild(removeButton);
                        
                        // Añadir el formulario clonado al contenedor
                        container.appendChild(newForm);
                    }
            </script>
           <style>
            .input-row {
                display: flex;
                margin-bottom: 10px;
                
            }
            input{
                margin-right: 10px;
                height: 50px!important;
                border: solid 1px rgba(0,0,0,.5)!important;
                padding: 10px!important;
                border-radius: 5px;
            }
            .input-row input {
                margin-right: 10px;
                width: 200px!important;
                border: solid 1px rgba(0,0,0,.5)!important;
                padding: 10px;
                border-radius: 5px;
            }
            .input-row button {
                margin-left: 10px;
              
            }
            .promps_btn{
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



