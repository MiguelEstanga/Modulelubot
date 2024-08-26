<div class="alert" style="display: none;" id="modal_preguntas_y_respuesta">

    <div class="container_preguntas_respuesta">
        <div class="cerrar" id="cerrar_rc" style="z-index: 10;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
            </svg>
        </div>
        <h2 class="fuente-titulo-xdefecto  txt-center" style="width: 859px; ">
            ¿Cómo debo hablar con tus clientes?
        </h2>
        <div class="text-layout " style="width: 739px; margin:auto;">
            Siempre puedes modificar mi forma de hablar con tus cliente en la sección de CONFIGURACIÓN.
        </div>
        <div class="container_configuracion">
            <input type="text" class="custom_input margin-none" name="como_me_llamo" placeholder="¿Cómo me llamo?">
            <select name="objetivo_lubot" class="form-control selectpicker" data-live-search="true">

                @foreach ($objetivos as $items)
                    <option value="{{ $items->id }}">{{ $items->nombre }}</option>
                @endforeach
            </select>

        </div>
        <div class="txt_">
            <textarea class="spbre_la_empresa" name="spbre_la_empresa" id="" cols="30" rows="10"
                placeholder="Cuéntame de tu negocio"></textarea>
        </div>
        <div class="_leyenda ">

            Aquí es donde me enseñas cómo debería hablar con tus clientes, enseñame tal y como lo harías con tu equipo
            comercial recuerda que si quieres enseñarme cosas nuevas siempre podrás hacerlo en el apartado de
            CONFIGURACIÓN.

        </div>
        <div class="preguntas_respuesta__" style="margin-top:10px;">
            <div id="form-container">
                <div class="preguntas_respuesta">
                    <div class="col-md-5">
                        <input type="text" class="custom_input margin-none" placeholder="Si el cliente dice:"
                            name="pregunta[]">
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="custom_input margin-none" placeholder="ubot debería responder:"
                            name="respuesta[]">
                    </div>
                    <div class="">
                        <button class="btn btn-success" type="button" onclick="addForm(this)">+</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn_enviar">
            <a href="{{route('chatGpt.index')}}" target="blacnk" class="btn btn-envio" type="submit">Prueba mis respuestas </a>
            <button 
                class="btn btn-envio" 
                type="submit" 
              
                id="__activar_rc"
            > Enviar Campaña </button>
            <button 
                class="btn btn-envio" 
                type="submit" 
                style="display: none"
                id="activar_campana"
            > Enviar </button>
        </div>
    </div>
</div>
</div>


<style>
    .preguntas_respuesta__ {
        overflow-y: scroll;
        height: 160px;
        margin-top: 10px;
        scrollbar-width: thin;
        /* Ancho de la scrollbar (auto, thin, none) */
        scrollbar-color: #888 #f1f1f1;
        /* Color del thumb y del track */

    }

    /* Estilo general para la scrollbar dentro del div */
    .preguntas_respuesta__::-webkit-scrollbar {
        width: 10px;
        /* Ancho de la scrollbar */
    }

    /* Estilo de la parte interna de la scrollbar */
    .preguntas_respuesta__::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Color de fondo del track de la scrollbar */
        border-radius: 10px;
        /* Bordes redondeados */
    }

    /* Estilo del thumb (la parte que se desplaza) de la scrollbar */
    .preguntas_respuesta__::-webkit-scrollbar-thumb {
        background: #888;
        /* Color del thumb */
        border-radius: 10px;
        /* Bordes redondeados */
    }

    /* Estilo del thumb al pasar el mouse por encima */
    .preguntas_respuesta__::-webkit-scrollbar-thumb:hover {
        background: #555;
        /* Color del thumb al hacer hover */
    }

    .btn_enviar {

        position: absolute;
        bottom: 0;
        left: 50px;
        margin: auto;
        width: 756px;
        height: 86px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    ._leyenda {

        width: 756px;
        height: 86px;
        margin: auto;
        margin-top: 10px;
        margin-bottom: 20px;
        font-size: 20px;
        line-height: 32px;
        font-weight: 400;
    }

    .txt_ {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10px;
    }

    .spbre_la_empresa {
        width: 756px;
        height: 121px;
        padding: 10px;
        margin: auto;
        border-radius: 10px;
    }

    .container_configuracion {

        margin: auto;
        margin-top: 30px;
        width: 756px;
        display: flex;
        gap: 20px;
    }

    #form-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .preguntas_respuesta {

        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container_preguntas_respuesta {
        padding: 10px;
        max-width: 859px;
        height: 691px;
        background: #fff;
        border-radius: 10px;
        position: relative;
    }

    .form-row {
        margin-bottom: 10px;
    }

    .form-control {
        height: 38px;
    }

    .promps_btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }
</style>
