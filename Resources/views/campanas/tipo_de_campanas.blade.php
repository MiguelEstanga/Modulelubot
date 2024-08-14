@extends('layouts.app')
@include('lubot::css.css')

@section('content')
    <div class="content-wrapper row">
        <div class="helper_container">
            @include('lubot::component.vamos-hacer-magia-juntos')
        </div>
        <div class="contenedor_tipo_de_campana" style="gap: 10px;">
            <div class="content_logo_helper row" style="margin-top: 40px; margin:auto;">
                <div class="logo" class="logo">
                    <img src="{{ $logo }}" alt="">
                </div>
                <div class="col-md-8">
                    <h2 class="fuente-titulo-xdefecto">
                        envía tu campaña
                    </h2>
                    <p class="text-layout" style="width: 530px;">
                        Selecciona la opción que más te guste
                    </p>
                    <div class="opciones_de_campana">
                        <div class="option_de_saludo row" style="margin-top: 40px;">
                            <div class="__header" class="logo">
                                <div class="logo" class="col-md-4">
                                    <img src="{{ $requiest }}" alt="">
                                </div>
                                <div class="leyenda">
                                    Solo saludaré a tu <br>
                                    cliente, el resto, <br>
                                    depende de ti
                                </div>
                                
                            </div>
                            <div class="btn_container" >
                                <a class="btn btn-success" style="width: 253px;">
                                    Campaña de Saludo
                                </a>
                            </div>
                        </div>
                        <div class="option_de_saludo row" style="margin-top: 40px;">
                            <div class="__header" class="logo">
                                <div class="logo" class="col-md-4">
                                    <img src="{{ $requiest }}" alt="">
                                </div>
                                <div class="leyenda">
                                    niciaré una conversacion con
                                    tus clientes, y los convenceré
                                    para cumplir mi objetivo, luego,
                                    haré una lista de los clientes interesados
                                </div>
                            </div>
                            <div class="btn_container" >
                                <a href="{{route('campanas.index')}}" class="btn color-fondo-primario">
                                    Campaña Pro
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
    <style>
        .btn_container{
           
            width: 100%;
            margin-top:20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn_container a{
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

            width: 707px;
            height: 159px;
        }

        .opciones_de_campana p {
            font-size: 16px;
        }

        .contenedor_tipo_de_campana {
            background: #fff;
            padding: 10px;
            margin-left: 70px;
            width: 1017px;
            height: 354px;
        }
    </style>
@endsection
