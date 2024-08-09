<ul>
    <li id="estado_rc">
        Estado rc:
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#5f6a6a" class="bi bi-lightbulb-off-fill"
            viewBox="0 0 16 16">
            <path
                d="M2 6c0-.572.08-1.125.23-1.65l8.558 8.559A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m10.303 4.181L3.818 1.697a6 6 0 0 1 8.484 8.484zM5 14.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5M2.354 1.646a.5.5 0 1 0-.708.708l12 12a.5.5 0 0 0 .708-.708z" />
        </svg>
    </li>
    <li id="codigo_linea_rc" style="display: none;">
        Codigo de linea rc :
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#145a32" class="bi bi-check"
            viewBox="0 0 16 16">
            <path
                d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
        </svg>
    </li>
    <li id="codigo_rc" style="display: none;">
        Codigo en rc : <span id="_codigo_rc"></span>
        </svg>
    <li id="rc_ejecucion" style="display: none;">
        rc ejecutandoce :
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#145a32" class="bi bi-check"
            viewBox="0 0 16 16">
            <path
                d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
        </svg>

    </li>
</ul>
<div class="container container_loader" style="margin:30px 0; display:none; " id="loader_rc">
    <div>Espere mientras se muestra el progreso: </div>
    <div class="loader"></div>
</div>

<div class="" style="margin-top: 20px;">
    <button class="btn btn-success" id="activar_rc">
        Activar rc
    </button>
</div>
<script>
    $(document).ready(function() {
        let start_rc = false;
        let intervalId;
        let countdownIntervalId;
        let countdownTime = 120; // 120 seconds
        let companie = {{ $id_companie }};
        let url_webhook_activar_rc = `{{ $activar_ws_url }}/${companie}/rc`;

        code_rc()

        function activar_bot() {
            console.log(`${url_webhook_activar_rc}`)
            fetch(`${url_webhook_activar_rc}`, {
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

        }

        function code_rc() {
            fetch(`{{ route('lubot.default_compania') }}`)
                .then(response => response.json())
                .then(response => {
                    console.log(response);
                    if (response.estado_rc === 1) {
                        estado_rc.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#f1c40f" class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                            <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5"/>
                        </svg>
                    `;
                    }

                    if (response.estado_rc === 2) {
                        estado_rc.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#186a3b" class="bi bi-lightbulb-fill" viewBox="0 0 16 16">
                            <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5"/>
                        </svg>`;
                    }

                    if (response.code_rc != null) codigo_linea_rc.style.display = 'block';
                    if ((response.estado_rc === 2 || response.estado_rc === 1) && response.code_rc != null) {
                        codigo_rc.style.display = "block";
                       // _codigo_rc.innerHTML = response.code_rc;
                        let code = response?.code_rc
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
                    if (response.code_rc != null && response.estado_rc == 2) {
                        rc_ejecucion.style.display = "block";
                        loader_rc.style.display = 'none';
                        clearInterval(intervalId);
                        clearInterval(countdownIntervalId);
                        activar_rc.disabled = false;
                        activar_rc.style.color = "";
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
                    activar_rc.disabled = false;
                    activar_rc.style.color = "";
                    loader_rc.style.display = 'none';
                }
            }, 1000);
        }

        $('#activar_rc').on('click', function() {
            if (!start_rc) {
                activar_bot();
                start_rc = true;
                loader_rc.style.display = 'block';
                activar_rc.disabled = true;
                activar_rc.style.color = "#f2f2f2";
                intervalId = setInterval(code_rc, 1000);
                startCountdown();
            }
        });
    });
</script>
