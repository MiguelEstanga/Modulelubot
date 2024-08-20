@extends('layouts.app')
@section('content')
    @include('lubot::css.css') 
    <div class="content-wrapper opciones">
        <a class="cart_url" href="{{route('tipo_de_campanas')}}">
            <div class="_container-action c-hover">
                <div class="url_option row" style="margin-top: 40px;">
                    <div class="logo" class="logo">
                        <img src="{{ $logo }}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h2 class="fuente-titulo-xdefecto">
                            Búsco clientes para tu negocio
                        </h2>
                        <p class="text-layout" style="width: 530px;">
                            Haré una revisión en internet identificando prospectos que
                            se ajusten a los criterios de tu negocio, en esta opción no
                            necesitas tener una base de datos de propia.
                        </p>

                    </div>

                </div>
            </div>
        </a>

        <a class="cart_url" href="{{route('Lubot.db')}}">
            <div class="_container-action c-hover" style="height: auto!important;">
                <div class="url_option row" style="margin-top: 40px;">
                    <div class="logo" class="logo">
                        <img src="{{ $logo }}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h2 class="fuente-titulo-xdefecto">
                            Tengo mi propia Base de Datos
                        </h2>
                        <p class="text-layout" style="width: 530px;">
                            Si ya tienes una base de datos, puedo contactarlos por ti
                        </p>

                    </div>

                </div>
            </div>
        </a>

    </div>
    <style>
        .cart_url {
            color: #000;
            transition: all linear .300s;
        }

        .url_option {

            width: 90%;
            margin: 0 auto;
        }

        .opciones {
           
            display: grid;
            height: 95vh;
            gap: 10px;
            align-content: center;
            justify-content: center;
        }
    </style>
@endsection
