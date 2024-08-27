@extends('layouts.app')
@section('content')
    @include('lubot::css.css')
    <div class="content-wrapper row ">
        @include('lubot::activacion.component.container-video')
        <div class="container-action">
            @include('lubot::activacion.component.activacion-lubot')
        </div>
    </div>
   

    @include('lubot::activacion.script_ws')
    <style>
    
        .container-action {
            
            display: grid;
            gap: 20px;
            margin-left: 50px;
        }

        .content_custom {
            height: 300px !important;
            width: 100%;
        }

        #iniciar {
            transition: opacity 0.5s ease-in-out;
        }

        #iniciar.loading {
            opacity: 1;
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
    </style>
@endsection
