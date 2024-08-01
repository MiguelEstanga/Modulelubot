@extends('layouts.app')



@section('content')
    @if (in_array('admin', user_roles()))

        <div class="content-wrapper">
            <form action="{{ route('lubot.activacion') }}" method="post" class="" autocomplete="on">
                @csrf
                @method('post')
                <div class="col-lg-12 row">
                    <div class="col-md-2 form-group my-3">
                        <label for="" class="f-14 text-dark-grey mb-12">
                            Código <sup class="f-14 mr-1">*</sup>
                        </label>
                        <select class="form-control selectpicker" data-live-search="true" style="margin-top: 50px;"
                            name="codigo">
                            @foreach ($codigos as $codigo)
                                <option value="{{ $codigo->id }}">{{ $codigo->codigos }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-10">
                        <x-forms.text class="mr-0 mr-lg-2 mr-md-2" fieldLabel="Numero de telefono"
                            fieldPlaceholder="Numero de telefono" fieldName="numero" fieldRequired="true"
                            fieldId="contract_prefix" :fieldValue="$numero" />
                    </div>
                </div>
                @if ($numero !== null)
                    <div class="container-fluid">
                        <div class="">

                            <p id="bd_codigo" style="display: none;">
                                codigo
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#145a32"
                                    class="bi bi-check" viewBox="0 0 16 16">
                                    <path
                                        d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                                </svg>
                            </p>
                            <p id="bd_verificado" style="display: none;">verificado
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#145a32"
                                    class="bi bi-check" viewBox="0 0 16 16">
                                    <path
                                        d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                                </svg>
                            </p>

                        </div>
                        <div class="cntainer" id="estado_ws_container">
                            @if ($data_companias->estado_ws === null)
                                Estado: <span id="estado">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#5f6a6a"
                                        class="bi bi-lightbulb-off-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2 6c0-.572.08-1.125.23-1.65l8.558 8.559A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m10.303 4.181L3.818 1.697a6 6 0 0 1 8.484 8.484zM5 14.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5M2.354 1.646a.5.5 0 1 0-.708.708l12 12a.5.5 0 0 0 .708-.708z" />
                                    </svg>
                                </span>
                            @elseif($data_companias->estado_ws === 1)
                                Estado: <span id="estado">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="gold"
                                        class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5" />
                                    </svg>
                                </span>
                            @elseif($data_companias->estado_ws === 2)
                                Estado: <span id="estado" style="color:gold;">
                                    <svg xmlns="http://www.w3.org/2000/svg" color="gold" width="20" height="20"
                                        fill="#fff" class="bi bi-check" viewBox="0 0 16 16">
                                        <path
                                            d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="container" style="margin: 10px">
                        <div class="container alert alert-success " style="width:90vw!important;" id="code_ws_container">
                            code: <span id="code"> {{ $data_companias->code_ws ?? '' }} </span>
                        </div>
                    </div>
                    <!--div class="container" id="code_container" style="margin: 10px">
                                            <div class="cntainer" >

                                                code: <span id="code_rc"></span>
                                            </div>
                                        </div-->

                    <div class="container container_loader" style="margin:30px 0; display:none; " id="loader">

                        <div>Espere mientras se muestra el progreso: </div>
                        <div class="loader"></div>

                    </div>
                @endif
                <div class="">
                    <button class="btn btn-success">
                        @if ($activacion === true)
                            Actulizar datos
                        @else
                            Activar
                        @endif
                    </button>

                    @if ($data_companias->estado_ws === 1 && $data_companias != null)
                    @else
                        <a class="btn btn-success" id="iniciar">
                            Iniciar
                        </a>
                    @endif

                </div>
            </form>
        </div>
        <script>
            let start = false;
            let intervalo;
            let pollingInterval;

            code_ws()

            function code_ws(mode = 1) {
                fetch(`{{ route('lubot.default_compania') }}`)
                    .then(response => response.json())
                    .then(data => {
                        // Verificar si los datos están definidos y no están vacíos
                        if (data.code_ws != null) seguir = bd_codigo.style.display = 'flex';
                        if (data.estado_ws != null) seguir = bd_verificado.style.display = 'flex';

                        if (data.estado_ws === 1 && data.code_ws != null) {
                            document.getElementById('code').innerHTML = data.code_ws;
                            document.getElementById('iniciar').display = 'none';
                            document.getElementById('code_ws_container').style.display = 'flex';
                            document.getElementById('estado').innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="gold" class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                                <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5"/>
                            </svg>`
                            document.getElementById('iniciar').style.display = 'none';

                            clearInterval(intervalo); // Detener la cuenta regresiva
                            document.getElementById('loader').style.display = 'none'
                            clearInterval(pollingInterval); // Detener el polling
                        } else {
                            document.getElementById('code_ws_container').style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            function cuentaRegresiva(time) {
                if (start) {
                    const tiempoTotal = time;
                    let tiempoRestante = tiempoTotal;
                    const elementoTiempo = document.getElementById('tiempo');
                    const loader = document.getElementById('loader')
                    intervalo = setInterval(() => {
                        tiempoRestante--;
                        //elementoTiempo.textContent = `Tiempo restante: ${tiempoRestante} segundos`;
                        loader.style.display = 'block';
                        if (tiempoRestante <= 0) {

                            clearInterval(intervalo);
                            loader.style.display = 'none'
                            code_ws(); // Realizar la consulta después de la cuenta regresiva
                            start = false; // Evitar que la cuenta regresiva se reinicie
                        }
                    }, 1000);
                }
            }

            document.getElementById('iniciar').addEventListener('click', function(e) {
                start = true;
                document.getElementById('iniciar').innerText = "Procesando...";

                
                fetch(`{{ route('probarbot') }}`)
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
               
                cuentaRegresiva(120);

                // Iniciar polling para verificar el estado_ws
                pollingInterval = setInterval(code_ws, 1000);
            });
        </script>
        </div>
    @endif
    <div class="container-fluid"></div>
@endsection
<style>
    #iniciar {
        transition: opacity 0.5s ease-in-out;
    }

    #iniciar.loading {
        opacity: 1;
    }

    /* HTML: <div class="loader"></div> */
    .container_loader{
       
        margin: auto;
    }
    .loader {
        width: 100%;
        height: 20px;
        background:
            linear-gradient(#25b09b 0 0) left -40px top 0/40px 20px,
            linear-gradient(#ddd 0 0) center/100% 50%;
        background-repeat: no-repeat;
        animation: l5 1s infinite linear;
    }

    @keyframes l5 {
        100% {
            background-position: right -40px top 0, center
        }
    }
</style>
