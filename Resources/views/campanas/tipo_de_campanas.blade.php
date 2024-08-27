@extends('layouts.app')
@include('lubot::css.css')

@section('content')
    <div class="content-wrapper row">
        <div class="helper_container">
            @include('lubot::component.vamos-hacer-magia-juntos')
        </div>

        <div class="contenedor_tipo_de_campana" style="gap: 10px;">

            <div class="content_logo_helper row" >
                <div class="lubot_">
                    <div class=" row">
                        <div class="logo" class="logo">
                            <img src="{{ $logo }}" alt="">
                        </div>
                        <div class="col-md-8">
                            <div style="">
                                <h2 class="fuente-titulo-xdefecto ">
                                    envía tu campaña
                                </h2>
                                <p class="text-layout" >
                                    Selecciona la opción que más te guste
                                </p>
                            </div>


                        </div>

                    </div>
                </div>
                <div class="opciones_de_campana">
                    <div class="pregunta">

                        <div class="content_pregunta">

                            <div class="baner_logo_leyenda_pregunta">
                                <div class="logo_request">
                                    <img src="{{ $requiest }}" width="77px" height="77px">
                                </div>
                                <p class="leyenda_pregunta">
                                    Iniciaré una conversacion con
                                    tus clientes, y los convenceré
                                    para cumplir mi objetivo, luego,
                                    haré una lista de los clientes interesados
                                
                                </p>

                            </div>
                            <div class="btn_container" >
                                <a href="{{ route('tipo_de_campanas') }}"
                                    style=""
                                    class="btn btn-success  color-segundario-text">
                                    Campaña de Saludo
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="pregunta">

                        <div class="content_pregunta">
                           
                            <div class="baner_logo_leyenda_pregunta">
                                <div class="logo_request">
                                    <img src="{{ $requiest }}" width="77px" height="77px">
                                </div>
                                <p class="leyenda_pregunta">
                                    Iniciaré una conversacion con
                                    tus clientes, y los convenceré
                                    para cumplir mi objetivo, luego,
                                    haré una lista de los clientes interesados
                                
                                </p>
                               
                            </div>
                            <div class="btn_container" >
                                <a href="{{ route('campanas.index') }}" style="color: #fff"
                                    class="btn content-btn-campana color-fondo-primario color-segundario-text">
                                    Campaña Pro
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    </div>
    <style>
      
        .baner_logo_leyenda_pregunta{
          
            display: grid;
            grid-template-columns:30% 70%;
            gap: 5px; 
            
        }
        .lubot_ {
            padding-left: 30px;
            max-width: 1007px;
            display: flex;

        }
      

        .btn_container {

            width: 100%;
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn_container a {
            color: #fff;
            padding: 10px;
        }

        .btn-optio-campana {
            width: 100%;
            position: relative;
            left: 35px;
        }

        .__header {
            gap: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .__header .leyenda {

            width: 277px;
            height: 72px;
        }

        .option_de_saludo {

            display: flex;
            justify-content: start;
            align-items: flex-start;
            width: 400px;
        }

        .option_de_saludo .logo {
            width: 77px;
            height: 77px;

        }

        .opciones_de_campana {
            display: flex;
            justify-content: center;
            gap: 30px;

            width: 1007px;
            height: 159px;
        }

        .opciones_de_campana p {
            font-size: 16px;
        }

        .contenedor_tipo_de_campana {
            background: rgb(255, 255, 255);
            display: grid;
            place-content: center;
            padding: 10px;
         
            width: 1017px;
            height: 354px;
        }

        @media (max-width: 1400px) {
            .lubot_ , .contenedor_tipo_de_campana{
                width: 60%;
            }
            .lubot_ {
                
                position: relative;
                right: -246px;
            }
        }
    </style>
@endsection
