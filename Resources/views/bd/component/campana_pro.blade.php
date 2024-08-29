<div class="">
    <div class="url_option row">
        <div class="logo" class="logo">
            <img src="{{ $logo }}" alt="">
        </div>
        <div class="col-md-8">
            <h2 class="fuente-titulo-xdefecto color-primario-text">
                Estás List@?
            </h2>
            <div style="position:relative; top:-27px;">
                <h2 class="fuente-titulo-xdefecto ">
                    envía tu campaña
                </h2>
                <p class="text-layout" style="position:relative; top:-20px;">
                    Selecciona la opción que más te guste
                </p>
            </div>


        </div>

    </div>
    <div class="pregunta">
       
            <div class="content_pregunta">
                <div class="logo_request">
                    <img src="{{ $requiest }}" width="77px" height="77px">
                </div>
                <div class="" >
                    <p class="leyenda_pregunta"  >
                        Iniciaré una conversacion con
                        tus clientes, y los convenceré
                        para cumplir mi objetivo, luego,
                        haré una lista de los clientes interesados
                        <div class="content-btn-campana" style="margin: auto;">
                            <a href="{{ route('tipo_de_campanas') }}" class="btn content-btn-campana color-fondo-primario color-segundario-text">
                                Campaña Pro
                            </a>
                        </div>
                    </p>
                    
                </div>

            </div>
       
    </div>
</div>
<style>
   
    .url_option{
        margin-left:50px;
        padding: 20px;
        max-width: 800px;
    }
   
</style>
