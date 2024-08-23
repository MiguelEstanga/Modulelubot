<script>
    let start = false;
    let intervalo;
    let pollingInterval;
    let companie = {{ $id_companie }};
    let url_webhook_activar_ws = `{{ $activar_ws_url }}/${companie}/ws`;

    code_ws()
    setTimeout(() => {
              container_loader.style.display ='none'
    }, 3000);

    function estado()
    {
        fetch(`{{route('estatus_estado')}}`)
        .then(response => response.json())
        .then(response => {
            if(response.estado_ws === 1 && response.code_ws === null)
            {
                display.style.display = 'block';
            }
        })
    }

    function resetear_estado()
    {   
        fetch(`{{route('reseteo')}}`)
        .then(response => response.json())
        .then(response => {
            console.log(response)
        })
    }
    cancelar_btn.addEventListener('click' , function(){
        resetear_estado()
        
        container_loader.style.display = 'none' 
        abra_cadabra.style.display = 'none'
        abra_cadabra_listo.style.display = 'none'
        clearInterval(pollingInterval)
       
    })

    function code_ws() {
       
        fetch(`{{ route('lubot.default_compania') }}`)
            .then(response => response.json())
            .then(data => {
                console.log(data)
                // Verificar si los datos están definidos y no están vacíos
                
                if ( data.estado_ws === 0 )  container_loader.style.display = 'flex' ;
                if(( data.estado_ws === 1 || data.estado_ws === 2) && data.code_ws !=null ) abra_cadabra.style.display = 'flex'
                if ( data.estado_ws === 2)  container_loader.style.display = 'none' ;
                if( data.estado_ws === 1 ) {
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
                }else{
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
               
                if (tiempoRestante <= 0) {

                    clearInterval(intervalo);
                    loader.style.display = 'none'
                    code_ws(); // Realizar la consulta después de la cuenta regresiva
                    start = false; // Evitar que la cuenta regresiva se reinicie
                }
            }, 1000);
        }
    }

    document.getElementById('activar_ws').addEventListener('click', function(e) {
        start = true;
        activar_ws.innerHTML = "cargando ..."
        activar_ws.disabled  = true
        
      //  document.getElementById('iniciar').innerText = "Procesando...";
        console.log(container_loader);
       
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
                //document.getElementById('iniciar').innerText = "Error de comunicación";
            })
            .finally(function() {
                activar_ws.disabled  = false
            });
        
        cuentaRegresiva(1);

        // Iniciar polling para verificar el estado_ws
        pollingInterval = setInterval(code_ws, 1000);
    });
</script>
