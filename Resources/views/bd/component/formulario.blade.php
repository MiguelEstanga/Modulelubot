<div class="container_formualrio_bd">

    <div class="container">
        <h2 class="fuente-titulo-xdefecto" style="padding-left: 20px;">
            Carga tu Base de datos
            <span style="font-size: 14px;" id='pregunta'>
                leeme

            </span>
            <svg id="svg_p" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-question-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path
                    d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94" />
            </svg>
        </h2>
        <form action="{{ route('bd.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="" style="padding-left:20px; ">
                <input class="custom_input" type="text" name="nombre_campana" placeholder="nombre de la campaña"
                    style="width: 389px!important;">
            </div>
            <div class="container_file">
                <div class="container">
                    <x-forms.file class="mr-0 mr-lg-2 mr-md-2" fieldLabel="" fieldPlaceholder="base de datos"
                        fieldName="file" fieldRequired="true" fieldId="contract_prefix" fieldValue="" />
                </div>
            </div>
            <div style="padding-left:20px; margin-bottom:20px;">
                <button class="color-fondo-primario btn color-segundario-text">
                    Registrar
                </button>

            </div>
            <div style="padding-left:20px; ">
                <a class="color-fondo-primario btn color-segundario-text" href="">
                    Descargar archivo de ejemplo
                </a>
            </div>

            <div class="p-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault" style="padding: 5px;">
                        Aceptas que tienes permiso para usar esta base de datos
                    </label>
                </div>
            </div>
            <!--div class="container" style="margin-top:30px;">
                <button class="btn btn-success" style="width: 100%!important;">
                    crear
                </button>
            </div-->
        </form>
    </div>
</div>
<div class="leeme" id="leeme">
    <div class="celda">
        <div class="cerrar" id="cerrar">
            X
        </div>
        <h2>
            !Importante debe seleccionar los negocios que estan acontinuacion de no estar el segmento de negocio que
            requiera debe pedir a soporte tecnico para que lo introdusca antes de enviar la base de datos!
        </h2>
        <div class="segmentos_disponibles">

            <table class="table tabl ">
                <thead>
                    <tr>
                        <td>
                            ID
                        </td>
                        <td>Tipo de negocio</td>
                    </tr>
                </thead>
                <tbody id="tbody_inset">

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        setTimeout(() => {

            $('#pregunta').addClass('leyenda_leeme')
            $('#pregunta').addClass('leyenda_leeme');
            $('#leeme').addClass('shrink-to-top');

        }, 1000);

        $('#pregunta').on('click', function() {
            $('#leeme').removeClass('shrink-to-top');
        })

        $('#cerrar').on('click' , function(){
            $('#leeme').addClass('shrink-to-top');
        })
        fetch(`{{ $url_segmentos }}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(element => {
                    tbody_inset.innerHTML += `
                   <tr>
                       <th scope="row">
                        ${element.id}
                       </th>
                       <th scope="row">
                            ${element.nombre}
                        </th>
                    </tr>
                `
                });
                console.log(data)
            })
    })
</script>
<style>
    .leyenda_leeme {
        text-shadow: 0 0 10px yellow, 0 0 20px yellow;
        cursor: pointer;
        animation: leyenda 1s infinite;
        transition: 0.5s linear;

    }

    @keyframes leyenda {
        0% {
            color: gold;
            text-shadow: 0 0 5px gold, 0 0 8px gold, 0 0 10px gold;
        }

        50% {
            color: #333;
            /* Color de fondo o un color contrastante */
            text-shadow: none;
        }

        100% {
            color: gold;
            text-shadow: 0 0 5px gold, 0 0 8px gold, 0 0 10px gold;
        }
    }

    .leeme.hiden {
        width: 0;
        height: 0;
        opacity: 0;
        display: none;
    }




    .leeme {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 1;
        background-color: rgba(0, 0, 0, .9);
        animation: linear 1s;
        animation: shrinkToTop 1s ease-in-out forwards;
        transition: 500ms linear all;
        display: grid;
        place-content: center;
    }

    .leeme .celda {
        border-radius: 10px;
        width: 800px;
        height: 500px;
        background-color: white;
        display: grid;
        position: relative;
    }

    .leeme .celda h2 {
        font-size: 15px;
        font-family: 'Courier New', Courier, monospace;
        text-align: center;
        padding: 20px;
    }

    .segmentos_disponibles {
        position: relative;
        width: 300px;
        margin: auto;
        height: 390px;
        overflow-y: scroll;
    }

    .cerrar {
        position: absolute;
        top: -32px;
        right: -21px;
        background-color: black;
        color: #fff;
        border-radius: 40px;
    }

    .shrink-to-top {
        animation: shrinkToTop 1s ease-in-out forwards;

        width: 1px;
        height: 1px;
        opacity: 0;
    }

    .container_file {
        width: 436px;
        height: 246px;

    }

    @media (max-width:1500px) {
        .container_formualrio_bd {

            width: 600px;
            margin: auto;
            position: relative;


        }
    }
</style>
