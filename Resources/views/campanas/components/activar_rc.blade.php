<div id="container_codigo_rc" class="alert" style="display: none;">
   
    <div id="cerrar">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
          </svg>
    </div>

    <div class="_container-action">
        <div  id="conten_loader_rc" class="conten_loader_rc" style="display: none;">
            <div class="loader"></div>
        </div>
        <div class="contenedor_action_center row">
            <div class="logo" class="logo">
                <img src="{{ $logo }}" alt="">
            </div>
            <div>
                <h2 class="fuente-titulo-xdefecto">
                    Sincronziza tu teléfono
                </h2>
                <p class="text-layout">
                    Ingresa este código para sincronizar tu teléfono con Lubot
                </p>
                <div id="_codigo_rc">

                </div>
            </div>

        </div>
       
    </div>
</div>

<style>
    .conten_loader_rc{
        padding: 10px;
        background: var(--color-primario-text);
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 10px;
    }
   
</style>
<script>
    $(document).ready(function() {
        let start_rc = false;
        let intervalId;
        let countdownIntervalId;
        let countdownTime = 120; // 120 seconds
         let companie = {{$companie}}; 
           let url_webhook_activar_rc =  `{{ $url_activar_rc }}/${companie}/rc`;
        setTimeout(() => {
            conten_loader_rc.style.display = 'none'
        }, 3000);
        code_rc();
      
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
                    document.getElementById('iniciar').innerText = "Volver a intentar";
                })
                .catch(error => {
                    console.error('Error en la solicitud:', error);
                    
                })
                .finally(function() {
                    alert('El bot acaba de iniciar, debe esperar alrededor de 60 segundos');
                });
        }

        function code_rc() {
            fetch(`{{ route('lubot.default_compania') }}`)
                .then(response => response.json())
                .then(response => {
                    console.log(response)
                    if(response.estado_rc === 0 || response.estado_rc === 2) conten_loader_rc.style.display = 'flex';
                    if (response.code_rc != null) {
                        if ((response.estado_rc === 2 || response.estado_rc === 1) && response.code_rc != null) 
                        {
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
                    if (response.code_rc != null && response.estado_rc == 2) 
                    {
                        
                       
                        clearInterval(intervalId);
                        clearInterval(countdownIntervalId);
                        conten_loader_rc.style.display = 'none';
                        if(start_rc)     modal_preguntas_y_respuesta.style.display = 'flex';
                       
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
                container_codigo_rc.style.display = 'flex'
                start_rc = true;
                
               
                intervalId = setInterval(code_rc, 1000);
                startCountdown();
            }
        });
        $('#cerrar').on('click', function() {
            console.log(container_codigo_rc)
            container_codigo_rc.style.display= 'none'
        });
    });
</script>
