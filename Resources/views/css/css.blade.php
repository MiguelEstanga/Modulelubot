<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap" rel="stylesheet">
<style>
    :root {
        --color-primario-text: #4E008E;
    }

    #cerrar {
        position: absolute;
        top: 50px;
        right: 100px;
        cursor: pointer;
    }

    .header_lubot_logo {
        width: 90%;
        position: relative;
        margin: auto;
    }

    .btn.btn-envio {
        background-color: var(--color-primario-text);
        color: #fff;
    }

    .input_number {
        width: 75px;
        height: 37px !important;
    }

    .custom_input {
        width: 483px;
        height: 37px !important;
        padding: 10px;
        margin: 20px 0;

    }

    .custom_input.margin-none{
        margin: 0!important; width: 297px!important;
    }

    .titulo_encabezado {
        border: solid 1px red;
    }

    .content-wrapper {
        display: flex;
       
        gap: 10px;
        justify-content: center !important;
        align-items: flex-start !important;

    }

    .color-primario-text {
        color: #4E008E;
    }
    .txt-center{
        text-align: center;
    }
    .c-hover:hover {
        color: #fff;
        background-color: var(--color-primario-text);
    }

    .color-segundario-text {
        color: #fff;
    }

    .color-fondo-primario {
        background: #4E008E !important;
    }

    .container-center-text {
        text-align: center;
    }

    .container-center-flex {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .text-layout {
        font-size: 20px;
        font-weight: 400;
        font-family: "Baloo 2";
        line-height: 32px;
    }

    .fuente-titulo-xdefecto {
        font-size: 32px;
        font-weight: 500;
        font-family: "Baloo 2";
        line-height: 51px;
        width: 517px;
    }

    ._container-action {

        position: relative;
        width: 757px;
        height: 251px;
        border-radius: 10px;
        background: #fff;
        transition: all linear 300ms;
        padding: 20px;
    }

    .divider {
        width: 90%;
        height: 1px;
        background-color: rgba(0, 0, 0, .5);
        margin: 40px 0;
    }

    .helper_container {
        border: solid 1px redñ background: #fff;
        max-width: 687px;
        height: 750px;
        border-radius: 10px;
        padding: 20px;
    }

    .container_info {
        height: auto;
        max-width: 1017px;
        background-color: #fff;
    }

    .content_logo_helper {
        width: 100%;
        margin: auto;
        padding: 10px;
        margin: 10px;
        display: flex !important;
        flex-direction: row;
        justify-content: center;
        gap: 10px;
        align-items: center;
    }

    .encabezado {

        max-width: 485px;
    }

    .vide-youtube {

        margin-top: 20px;
        text-align: center;
    }

    .vide-youtube .video {}

    .video {
        max-width: 600px;
        height: 312px;
        background: #f2f2f2;
        margin: auto;
        margin: auto;
        border-radius: 10px;
    }

    .p-10 {
        padding: 10px;
    }

    .container_info {
        background: #fff;
        padding: 10px;
        margin-left: 70px;
        width: 1017px;
        height: 354px;
    }




    .code-container {
        display: flex;
        align-items: center;
    }

    #code,
    #_codigo_rc {
        display: flex;
        justify-content: start;
        align-items: flex-start;
        background-color: #ffffff;
        margin-top: 10px 0;
        font-family: Arial, sans-serif;
    }

    .code-part {
        font-weight: bold;
        font-size: 20px;
        padding: 10px;
        margin: 0 2px;
        border: 2px solid #085837;
        border-radius: 5px;
        text-align: center;
        background-color: #fff;
    }

    .separator {
        font-weight: bold;
        font-size: 20px;
        margin: 0 5px;
    }

    .container-loader {
        width: 100%;
        height: 100%;
        background-color: #514b82;
        position: absolute;
        z-index: 10;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    #iniciar {
        transition: opacity 0.5s ease-in-out;
    }

    #iniciar.loading {
        opacity: 1;
    }

    .alert {
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 10;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .loader {
        width: 50px;
        padding: 8px;
        aspect-ratio: 1;
        border-radius: 50%;
        background: #f7faf9;
        --_m:
            conic-gradient(#0000 10%, #000),
            linear-gradient(#000 0 0) content-box;
        -webkit-mask: var(--_m);
        mask: var(--_m);
        -webkit-mask-composite: source-out;
        mask-composite: subtract;
        animation: l3 1s infinite linear;
    }
    @keyframes l3 {to{transform: rotate(1turn)}}
</style>
