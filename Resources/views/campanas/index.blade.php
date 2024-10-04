@extends('layouts.app')
@section('content')
    @include('lubot::css.css')
    <div class="container-crear-campana">
        
        @include('lubot::component.vamos-hacer-magia-juntos')

        <div class="container-action">
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
            let url_webhook_activar_rc = `{{ $url_activar_rc }}`;
            let bearer = `{{$bearer}}`;
            setTimeout(() => {
                conten_loader_rc.style.display = 'none'
            }, 3000); 

            $('#cerrar_rc').on('click', function() {
                modal_preguntas_y_respuesta.style.display = 'none';
            });

            let codeContainer = document.getElementById('_codigo_rc');


            function btn_activar_campana() {
                const button = document.getElementById("activar_campana");

                // Deshabilitar el botón
                button.disabled = true;

                // Mostrar el texto inicial del botón y la cuenta regresiva
                let timeLeft = 5;
                button.innerHTML = `Reintentar en ${timeLeft}s`;

                // Cada 1 segundo, actualiza el contador
                const countdown = setInterval(() => {
                    timeLeft--;
                    button.innerHTML = `Reintentar en ${timeLeft}s`;

                    // Cuando el contador llega a 0, vuelve a habilitar el botón
                    if (timeLeft <= 0) {
                        clearInterval(countdown);
                        button.disabled = false;
                        button.innerHTML = "Activar Campaña";
                    }
                }, 1000);
            }



            function activar_bot() {

                fetch(url_webhook_activar_rc, {
                        headers: {
                            'ngrok-skip-browser-warning': 'true',
                            'Authorization' : `Bearer ${bearer}`
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
                        if (parseInt(response.estado_rc) === 0 || parseInt(response.estado_rc) === 2) {
                            conten_loader_rc.style.display = 'flex';
                            console.log('response.estado_rc === 0 || response.estado_rc === 2 linea80')
                        }
                        if (response.code_rc != null) {
                            
                            if ( (parseInt(response.estado_rc) === 2 || parseInt(response.estado_rc) === 1) ) {

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
                        if (response?.code_rc != null && parseInt(response.estado_rc) == 2) {
                           
                            conten_loader_rc.style.display = 'none';
                            code_verificacion_rc.style.display = 'grid'
                            

                            comprobacion()
                            clearInterval(intervalId);
                            clearInterval(countdownIntervalId);
                            __activar_rc.style.display = "none"
                            activar_campana.style.display = "flex"

                        }
                    });
            }

            function startCountdown() {
                countdownTime = 2000 ;
                countdownIntervalId = setInterval(function() {
                    countdownTime--;
                    console.log(countdownTime)
                    if (countdownTime <= 0) {
                        clearInterval(countdownIntervalId);
                        clearInterval(intervalId);
                        //activar_rc.disabled = false;
                        //activar_rc.style.color = "";
                        //loader_rc.style.display = 'none';
                    }
                }, 1000);
            }

            $('#activar_campana').on('click', function() {
                btn_activar_campana(true)
                storeCampana()
            })

            //function campana store 
            function storeCampana(activar_campana) {
                // Asegúrate de que la ruta sea interpolada correctamente en el Blade.
                const url = `{{ $campana_store }}`;

                const data = JSON.parse(localStorage.getItem('formData'))
                if (data) {
                    if (typeof data.paises === "string") data.paises = JSON.parse(data.paises);
                    if (typeof data.ciudades === "string") data.ciudades = JSON.parse(data.ciudades);
                    if (typeof data.barrios === "string") data.barrios = JSON.parse(data.barrios);
                    if (typeof data.cantidades === "string") data.cantidades = JSON.parse(data.cantidades);
                    if (typeof data.preguntas_respuestas === "string") data.preguntas_respuestas = JSON.parse(data
                        .preguntas_respuestas);
                }
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content') // Añadir el token CSRF
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        return response.json();
                    })
                    .then(responseData => {
                        console.log(responseData)
                        if (responseData.status === 200) {
                            modal_preguntas_y_respuesta.style.display = 'none'
                            //pisa papeles aqui finaliza preguntas y respuesta 
                            setTimeout(function() {
                                //window.location.href = responseData.route;
                            }, 2000);

                        } else {
                            alert(responseData.message)
                        }



                        // Aquí puedes manejar la respuesta del servidor
                    })
                    .catch(error => {
                        console.log(error)
                        alert(
                            'Asegurece de llenar los campos en especial los de segmentos, si se refresco la pagina en el transcurso deseleccione y vuelva a seleccioar los selectores '
                        )
                    })
                    .finally(() => {
                        __activar_rc.disabled = false;
                    })
            }

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
                let estado_bd_rc = parseInt(`{{ $config_lubot->estado_rc }}`)

                if (!start_rc) {
                    if (code_bd_rc == 1 && estado_bd_rc == 2) return;
                    if (parseInt(estado_bd_rc) === 0 && parseInt(code_bd_rc) === 0) {
                        activar_bot() //aqui se activa el bot rc
                        console.log('aqui esta la activacion del bot ')
                    }

                    __activar_rc.disabled = false
                    __activar_rc.innerHTML = 'Enviar de nuevo'
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
        .container-crear-campana {
            display: flex;
            width: 85vw;
            justify-content: center !important;
            align-items: flex-start !important;
        }

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

        @media (max-width: 1400px) {
            .btn_container {
                margin-top: 20px;
            }

            .helper_container {

                width: 900px !important;

            }

            .container_info {
                max-width: 600px;
                position: relative;
                left: -34px;
            }

            .container-crear-campana {


                width: 78vw;

            }

            .helper_container {

                border-radius: 10px;
                padding: 2px;
                position: relative;
                left: 20px;

            }


            @media (max-width: 1800px) {

                .lubot_,
                .contenedor_tipo_de_campana {
                    width: 60%;
                }

                .lubot_ {

                    position: relative;
                    right: -246px;
                }

                .helper_container {

                    width: 550px !important;
                }

                .video {
                    width: 510px !important;
                }
            }
    </style>
    </div>
@endsection
