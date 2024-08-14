<div class="_container-action row">
    <div class="container-loader" style="display:none;" id="container_loader">
        <div class="loader"></div>
        <div class="fuente-titulo-xdefecto"  style="color: #fff!important; ">
            Estamos haciendo mágia, espera...
        </div>
    </div>
    <div class="container-loader" style="display:none;" id="abra_cadabra">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" fill="#fff" class="bi bi-check-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
              </svg>
        </div>
        <div class="fuente-titulo-xdefecto"  style="color: #fff!important; text-align:center;">
            Abra Kadabra!
        </div>
    </div>
   
    <div class="contenedor_action_center row">

        <div class="logo">
            <img src="{{ $logo }}" alt="">
        </div>
        <div id="dinamic_loader" class="col-md-6">

            <h2 class="fuente-titulo-xdefecto">
                Agrega tu Whatsapp Bussiness
            </h2>
            <form action="{{ route('lubot.activacion') }}" method="POST" autocomplete="on">
                @csrf

                <div class="">

                    <div class="form_number">

                        <select class="form-control selectpicker selec_code" data-live-search="true" name="codigo">
                            @foreach ($codigos as $codigo)
                                <option value="{{ $codigo->id }}">{{ $codigo->codigos }}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control" value="{{ $numero }}" name="numero">
                    </div>
                    <div class="col-md-6">

                    </div>

                </div>
                <div class="contenedor-boton-activar">
                    <button class="btn btn-success">
                        Activar
                    </button>
                   
                </div>
            </form>
            <div style="margin-top:10px; ">
                <button class="btn btn-success" id="activar_ws">
                    Activar ws
                </button>
            </div>
        </div>
    </div>

</div>
<div class="_container-action">
    <div class="container-loader" style="display:none" id="abra_cadabra_listo">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" fill="#fff" class="bi bi-check-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
              </svg>
        </div>
        <div class="fuente-titulo-xdefecto"  style="color: #fff!important; text-align:center;">
            Un poco de magia, y voilà!
        </div>
    </div>
    <div class="contenedor_action_center row" style="margin-top: 20px;">
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
            <div id="code">

            </div>
        </div>

    </div>
</div>
<div class="_container-action">
    <div class="contenedor_action_center row" style="margin-top: 10px;">
        <div class="logo" class="logo">
            <img src="{{ $logo }}" alt="">
        </div>
        <div class="col-md-8">
            <h2 class="fuente-titulo-xdefecto">
                Crea tu primera campaña
            </h2>
            <p class="text-layout" style="width: 540px;">
                El primer asistente con Inteligencia Artificial, capaz de conectar
                tu negocio con potenciales clientes en todo el mundo <br>
                <div id="crear_campana">

                </div>
               
              
            </p>

        </div>

    </div>
</div>
<script>
    let codeContainer = document.getElementById('code');

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
</script>
<style>
    .dinamic_loader {
        position: relative;
    }


    .logo {
        margin-right: 20px;
    }

    .contenedor_action_center {
        width: 90%;
        position: relative;
        margin: auto;
    }

    .form_number {

        width: 536px;
        display: flex;

    }

    .selec_code {
        width: 100px !important;
    }

    .form_number input {
        width: 436px;
    }

    .contenedor-boton-activar {

        margin-top: 20px;
    }



    .code_ {

        width: 566px;
        display: flex;
        gap: 10px;
    }

    .code {
        border: solid 1px red;
        border-radius: 10px;
        width: 38px;
        height: 53px;

    }


</style>
