<div class="container">
    <div class="url_option row" style="margin-top: 40px; margin-left:20px;">
        <div class="logo" class="logo">
            <img src="{{ $logo }}" alt="">
        </div>
        <div class="col-md-8">
            <h2 class="fuente-titulo-xdefecto color-primario-text">
                Estás List@?
            </h2>
            <div style="position:relative; top:-20px;">
                <h2 class="fuente-titulo-xdefecto ">
                    envía tu campaña
                </h2>
                <p class="text-layout" style="position:relative; top:-20px;">
                    Selecciona la opción que más te guste
                </p>
            </div>


        </div>

    </div>
    <div style="margin-left:150px; ">
        <div class="url_option row" style="margin-top: 40px; margin-left:20px;">
            <div class="logo_request" class="logo">
                <img src="{{ $requiest }}" alt="">
            </div>
                <div class="col-md-6" style="position:relative; top:-20px;">
                    <p class="text-layout" style="position:relative; top:-20px;">
                        Iniciaré una conversacion con
                        tus clientes, y los convenceré
                        para cumplir mi objetivo, luego,
                        haré una lista de los clientes interesados
                    </p>
                </div>
                
        </div>
        <div class="content-btn-campana">
            <a href="{{route('tipo_de_campanas')}}" class="btn color-fondo-primario color-segundario-text">
                Campaña Pro
            </a>
        </div>
    </div>
    
</div>
<style>
    .content-btn-campana{
       
        display: flex;
        justify-content: center;
        align-items: center;
        width: 577px;
        height: 37px;
    }
    .logo_request{
      
        height: 100px;
        position: relative;
        top: -25px;
    }
</style>
