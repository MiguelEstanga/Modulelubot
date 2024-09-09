<script>
    let start = false;
    let intervalo;
    let pollingInterval;
    let companie = {{ $id_companie }};
    let url_webhook_activar_ws = `{{ $activar_ws_url }}/${companie}/ws`;

    code_ws()
    setTimeout(() => {
        container_loader.style.display = 'none'
    }, 3000);

    function estado() {
        fetch(`{{ route('estatus_estado') }}`)
            .then(response => response.json())
            .then(response => {
                if (response.estado_ws === 1 && response.code_ws === null) {
                    container_loader.style.display = 'block';
                }
            })
    }

    function resetear_estado() {
        fetch(`{{ route('reseteo') }}`)
            .then(response => response.json())
            .then(response => {

                console.log(response)
            })
    }
    cancelar_btn.addEventListener('click', function() {
        clearInterval(pollingInterval)
        resetear_estado()
        estado()
        code_ws(false)
        codeContainer.innerHTML =""
        start = false 
        document.getElementById('contador_espera').style.display ="none"
        abra_cadabra.style.display = 'none'
        activar_ws.innerHTML = "Activar"
        container_loader.style.display = 'none'
        abra_cadabra.style.display = 'none'
        abra_cadabra_listo.style.display = 'none'

    })

    //para pintar el codigo
    function pintar_codigo(code) {
        let codeContainer = document.getElementById('code');
        codeContainer.innerHTML = ""
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

    function code_ws(reset = true) {

        fetch(`{{ route('lubot.default_compania') }}`)
            .then(response => response.json())
            .then(data => {
                console.log(data)
                // Verificar si los datos están definidos y no están vacíos
                if (reset) {
                    if (data.estado_ws === 0) container_loader.style.display = 'flex';
                }
               
                if ((data.estado_ws === 1 || data.estado_ws === 2) && data.code_ws != null) abra_cadabra.style
                    .display = 'flex'
                if (data.estado_ws === 2) container_loader.style.display = 'none';
                if (data.estado_ws === 1) {
                    contador_espera.style.display = 'block'
                  
                }
                if (data.estado_ws === 2) {
                    abra_cadabra_listo.style.display = 'flex'
                    crear_campana.innerHTML = `
                        <a class="btn btn-success" 
                        style="
                            width:180px!important;
                        "
                        href="{{ route('campanas_opciones') }}">
                        Crear ahora
                    </a>
                    `
                } else {
                    crear_campana.innerHTML = `
                        <a class="btn "
                        style="
                            width:180px!important;
                            
                            background-color: #737373;
                            color:#fff;
                        "
                        >
                        Crear ahora
                    </a>
                    `
                }
                if ((data.estado_ws === 1 || data.estado_ws === 2) && data.code_ws != null) {
                    let code = data?.code_ws
                    pintar_codigo(code)
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
            const elementoTiempo = document.getElementById('code_espera');

            intervalo = setInterval(() => {
                tiempoRestante++;
                elementoTiempo.textContent = `${tiempoRestante} `;
            }, 1000);
        }
    }

    document.getElementById('activar_ws').addEventListener('click', function(e) {
        start = true;
        let numero_de_telefono = numero_telefono.value
        let codigo_de_region = codigo_region.value

        codigo_region.addEventListener('onchange', function(event) {
            codigo_de_region = event.value
        })
        numero_telefono.addEventListener('input', function(event) {
            numero_de_telefono = event.value
        })

        let metadata_telefono = new FormData();
        metadata_telefono.append('numero', numero_de_telefono)
        metadata_telefono.append('codigo', codigo_de_region)

        fetch(`{{ route('lubot.activacion') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content') // Añadir el token CSRF
                },
                body: JSON.stringify({
                    numero: numero_de_telefono,
                    codigo: codigo_de_region
                })
            })
            .then(response => response.json())
            .then(response => console.log(response))



        activar_ws.innerHTML = "cargando..."
        activar_ws.disabled = true
        fetch(`${url_webhook_activar_ws}`, {
                headers: {
                    'ngrok-skip-browser-warning': 'true'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Raw data:', data);
                document.getElementById('iniciar').innerText = "Volver a intentar";
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                //document.getElementById('iniciar').innerText = "Error de comunicación";
            })
            .finally(function() {
                activar_ws.disabled = false
            });

        cuentaRegresiva(1);

        // Iniciar polling para verificar el estado_ws
        pollingInterval = setInterval(code_ws, 1000);
    });
</script>
