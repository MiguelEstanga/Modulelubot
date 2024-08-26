@extends('layouts.app')
@section('content')
    @include('lubot::css.css')
    <div class="content-wrapper">
        <div class="helper_container">
            @include('lubot::component.vamos-hacer-magia-juntos')
        </div>
        <div>
            @include('lubot::campanas.components.formulario')
        </div>

    </div>

    <script>
        $(document).ready(function() {
            let start_rc = false;
            let intervalId;
            let countdownIntervalId;
            let countdownTime = 120; // 120 seconds
            let companie = {{ $companie }};
            let url_webhook_activar_rc = `{{ $url_activar_rc }}/${companie}/rc`;
            setTimeout(() => {
                conten_loader_rc.style.display = 'none'
            }, 3000);

            $('#cerrar_rc').on('click', function() {
                modal_preguntas_y_respuesta.style.display = 'none';
            });

            let codeContainer = document.getElementById('_codigo_rc');

            for (let i = 0; i < 8; i++) {
                if (i === 4) {
                    // Insertar el guion después de 4 caracteres
                    const separator = document.createElement('div');
                    separator.className = 'separator';
                    separator.textContent = '-';
                    codeContainer.appendChild(separator);
                }

                // Crear un nuevo div para el carácter
                const codePart = document.createElement('div');
                codePart.className = 'code-part';
                codePart.textContent = '';

                // Insertar el carácter en el contenedor
                codeContainer.appendChild(codePart);
            }

            function activar_bot() {

                fetch(url_webhook_activar_rc, {
                        headers: {
                            'ngrok-skip-browser-warning': 'true'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Raw data:', data);

                    })
                    .catch(error => {
                        console.error('Error en la solicitud:', error);


                    })
                    .finally(function() {
                        //alert('El bot acaba de iniciar, debe esperar alrededor de 60 segundos');
                    });
            }

            function code_rc() {

                fetch(`{{ route('lubot.default_compania') }}`)
                    .then(response => response.json())
                    .then(response => {
                        console.log(response)
                        console.log('sin condicion')
                        if (response.estado_rc === 0 || response.estado_rc === 2) {
                            conten_loader_rc.style.display = 'flex';
                            console.log('response.estado_rc === 0 || response.estado_rc === 2 linea80')
                        }
                        if (response.code_rc != null) {
                            console.log('response.code_rc != null')
                            if ((response.estado_rc === 2 || response.estado_rc === 1) && response.code_rc != null) {
                                console.log(
                                    '(response.estado_rc === 2 || response.estado_rc === 1) && response.code_rc != null'
                                    )
                                _codigo_rc.innerHTML = '';
                                let code = response.code_rc;
                                let codeContainer = _codigo_rc;
                                for (let i = 0; i < code.length; i++) {
                                    if (i === 4) {
                                        // Insertar el guion después de 4 caracteres
                                        const separator = document.createElement('div');
                                        separator.className = 'separator';
                                        separator.textContent = '-';
                                        codeContainer.appendChild(separator);
                                    }
                                    // Crear un nuevo div para el carácter
                                    const codePart = document.createElement('div');
                                    codePart.className = 'code-part';
                                    codePart.textContent = code[i];

                                    // Insertar el carácter en el contenedor
                                    codeContainer.appendChild(codePart);

                                }
                            }

                        }
                        if (response?.code_rc != null && response?.estado_rc == 2) {
                            clearInterval(intervalId);
                            clearInterval(countdownIntervalId);
                            conten_loader_rc.style.display = 'none';
                            code_verificacion_rc.style.display = 'grid'
                            console.log('response.code_rc != null && response.estado_rc == 2')
                            storeCampana()
                        }
                    });
            }

            function startCountdown() {
                countdownTime = 120;
                countdownIntervalId = setInterval(function() {
                    countdownTime--;
                    if (countdownTime <= 0) {
                        clearInterval(countdownIntervalId);
                        clearInterval(intervalId);
                        //activar_rc.disabled = false;
                        //activar_rc.style.color = "";
                        //loader_rc.style.display = 'none';
                    }
                }, 1000);
            }
            
            $('#activar_campana').on('click' , function (){
                    console.log('aqui activo a lubot')
                    storeCampana()
                    return
            })

            $("#__activar_rc").on('click', function() {
                __activar_rc.disabled = true
                __activar_rc.innerHTML = 'cargando ...'

                const validacion = JSON.parse(localStorage.getItem('formData'));
                const preguntas_respuesta = JSON.parse(validacion.preguntas_respuestas)

                if (validacion.como_me_llamo.length < 4) alert('Debe colocar un nombre a Lubot')
                if (validacion.spbre_la_empresa.length < 4) alert(
                    'Debes dar una descripcion de lo que buscas')
                preguntas_respuesta.forEach(element => {
                    if (element.pregunta.length < 3) alert('hay una pregunta con menos de 3 letras')
                    if (element.respuesta.length < 3) alert(
                        'hay una respuesta con menos de 3 letras')
                });


                let code_bd_rc = `{{ $config_lubot->code_rc === null ? 0 : 1 }}`
                let estado_bd_rc = `{{ $config_lubot->estado_rc }}`
             
                if (!start_rc) {
                    if (code_bd_rc == 1 && estado_bd_rc == 2) return;
                    if (parseInt(estado_bd_rc) === 0 && parseInt(code_bd_rc) === 0) {
                        activar_bot() //aqui se activa el bot rc
                        console.log('aqui esta la activacion del bot ')
                    }
                    // container_codigo_rc.style.display = 'flex'
                    modal_preguntas_y_respuesta.style.display = 'none'
                    container_codigo_rc.style.display = 'flex'
                    start_rc = true;
                    intervalId = setInterval(code_rc, 1000);
                    startCountdown();
                }


            })



            $('#cerrar').on('click', function() {
                console.log(container_codigo_rc)
                container_codigo_rc.style.display = 'none'
            });
        });
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
@endsection
