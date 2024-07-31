@extends('layouts.app')



@section('content')
   @if(in_array('admin', user_roles()))
            
<div class="content-wrapper" >
                    <form action="{{route('lubot.activacion')}}" method="post" class=""  autocomplete="on">
                           @csrf
                           @method("post")
                           <div class="col-lg-12 row">
                                <div class="col-md-2 form-group my-3">
                                    <label for="" class="f-14 text-dark-grey mb-12">
                                        Código <sup class="f-14 mr-1">*</sup>
                                    </label>
                                    <select class="form-control selectpicker" data-live-search="true" style="margin-top: 50px;" name="codigo">
                                        @foreach($codigos as $codigo)
                                            <option value="{{$codigo->id}}">{{$codigo->codigos}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-10">
                                    <x-forms.text class="mr-0 mr-lg-2 mr-md-2" fieldLabel="Numero de telefono" fieldPlaceholder="Numero de telefono" fieldName="numero"
                                    fieldRequired="true" fieldId="contract_prefix" :fieldValue="$numero" />
                                </div>
                           </div>
                           @if($numero !== null)
                           <div class="container" style="margin: 10px">
                                <div class="cntainer" id="estado_ws_container" >
                                    @if( $data_companias->estado_ws === null )
                                        Estado: <span id="estado">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightbulb-off-fill" viewBox="0 0 16 16">
                                                <path d="M2 6c0-.572.08-1.125.23-1.65l8.558 8.559A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m10.303 4.181L3.818 1.697a6 6 0 0 1 8.484 8.484zM5 14.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5M2.354 1.646a.5.5 0 1 0-.708.708l12 12a.5.5 0 0 0 .708-.708z"/>
                                              </svg>
                                        </span>
                                    @elseif( $data_companias->estado_ws === 1)
                                        Estado: <span id="estado">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                                                <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5"/>
                                              </svg>
                                        </span>
                                    @elseif( $data_companias->estado_ws === 2)
                                         Estado: <span id="estado">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                              </svg>
                                         </span>
                                    @endif
                                </div>
                            </div>  
                            <div class="container" style="margin: 10px">
                                <div class="cntainer" id="code_ws_container" >
                                    code: <span id="code"></span>
                                </div>
                            </div>  
                            <div class="container" id="code_container" style="margin: 10px">
                                <div class="cntainer" >

                                    code: <span id="code_rc"></span>
                                </div>
                            </div>  
                            
                            <div class="container" style="margin: 10px" >
                                <div class="tiempo" id="tiempo">
                                    
                                </div>
                            </div>
                           @endif
                           <div class="">
                             <button class="btn btn-success">
                                @if($activacion === true)
                                    Actulizar datos
                                @else
                                    Activar 
                                @endif
                             </button>
                             <a class="btn btn-success" id="iniciar">
                                    Iniciar 
                             </a>
                           </div>
                    </form>
    </div>
<script>
    let start = false;
    let intervalo;
    let pollingInterval;

function code_ws() {
    fetch(`{{route('lubot.default_compania')}}`)
        .then(response => response.json())
        .then(data => {
            // Verificar si los datos están definidos y no están vacíos
            if (data.code_ws) {
                document.getElementById('code').innerHTML = data.code_ws;
                document.getElementById('code_ws_container').style.display = 'flex';
                clearInterval(intervalo); // Detener la cuenta regresiva
                clearInterval(pollingInterval); // Detener el polling
            } else {
                document.getElementById('code_ws_container').style.display = 'none';
            }

            if (data.code_rc) {
                document.getElementById('code_rc').innerHTML = data.code_rc;
                document.getElementById('code_container').style.display = 'flex';
            } else {
                document.getElementById('code_container').style.display = 'none';
            }

            // Revisar el estado_ws
            if (data.estado_ws === 1) {
                // Detener todo
                document.getElementById('estado').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                                                <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5"/>
                                              </svg>`
                clearInterval(pollingInterval);
                document.getElementById('iniciar').disabled = true;
                document.getElementById('iniciar').innerText = "Proceso finalizado";
                //alert("El proceso ha sido completado y el sistema está inactivo.");
            }

        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function cuentaRegresiva() {
    if (start) {
        const tiempoTotal = 60;
        let tiempoRestante = tiempoTotal;
        const elementoTiempo = document.getElementById('tiempo');

        intervalo = setInterval(() => {
            tiempoRestante--;
            elementoTiempo.textContent = `Tiempo restante: ${tiempoRestante} segundos`;

            if (tiempoRestante <= 0) {
                clearInterval(intervalo);
                code_ws(); // Realizar la consulta después de la cuenta regresiva
                start = false; // Evitar que la cuenta regresiva se reinicie
            }
        }, 1000);
    }
}

document.getElementById('iniciar').addEventListener('click', function (e) {
    start = true;
    document.getElementById('iniciar').innerText = "Procesando...";
    
    fetch(`{{route('probarbot')}}`)
        .then(response => response.json())
        .then(data => {
            console.log('Raw data:', data);
            document.getElementById('iniciar').innerText = "Volver a intentar";
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            document.getElementById('iniciar').innerText = "Error de comunicación";
        })
        .finally(function () {
            alert('El bot acaba de iniciar, debe esperar alrededor de 60 segundos');
        });
        
    cuentaRegresiva();

    // Iniciar polling para verificar el estado_ws
    pollingInterval = setInterval(code_ws, 1000);
});

</script>
</div>
 @endif
    <div class="container-fluid"></div>
@endsection
<style>
    
</style>


