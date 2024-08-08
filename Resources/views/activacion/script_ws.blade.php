<script>
    let start = false;
    let intervalo;
    let pollingInterval;
    let companie = {{ $id_companie }};
    let url_webhook_activar_ws = `{{ $activar_ws_url }}/${companie}`;

    code_ws()

    function code_ws(mode = 1) {
        fetch(`{{ route('lubot.default_compania') }}`)
            .then(response => response.json())
            .then(data => {
                console.log(data)
                // Verificar si los datos están definidos y no están vacíos
                if (data.code_ws != null) codigobd.style.display = 'block';
                if (data.estado_ws === 1 || data.estado_ws === 2) codigows.style.display = 'block';
                if (data.estado_ws === 2) {

                    document.getElementById('iniciar').style.display = 'none';
                    loginfinalizado.style.display = 'block'
                }

                if ((data.estado_ws === 1 || data.estado_ws === 2) && data.code_ws != null) {
                    code_ws_container.style.display = "block"
                    document.getElementById('code').innerHTML = data?.code_ws ?? '';
                    document.getElementById('estado').innerHTML = `
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#f1c40f" class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                            <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5"/>
                        </svg>
                    `
                }

                if (data.estado_ws === 2) {

                    document.getElementById('estado').innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#f1c40f" class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                                        <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5"/>
                                    </svg>`
                    clearInterval(intervalo); // Detener la cuenta regresiva
                    document.getElementById('loader').style.display = 'none'
                    clearInterval(pollingInterval); // Detener el polling
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

        console.log(`${url_webhook_activar_ws}`)
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
                document.getElementById('iniciar').innerText = "Error de comunicación";
            })
            .finally(function() {
                alert('El bot acaba de iniciar, debe esperar alrededor de 60 segundos');
            });

        cuentaRegresiva(500);

        // Iniciar polling para verificar el estado_ws
        pollingInterval = setInterval(code_ws, 1000);
    });
</script>
