@extends('layouts.app')
@section('content')
    @include('lubot::css.css')

    <div class="content-wrapper">
        @include('lubot::bd.component.helper_user')

        <div class="contain-bd " style="gap: 10px; border;">
            @if (session('mensage'))
                <h2 class=" alert-success" style="padding: 10px;">
                    {{ session('mensage') }}
                </h2>
            @endif

            <div class="bd_container  color container_1">

                <div class="col-md-6 p-5">
                    @include('lubot::bd.component.formulario')
                </div>
                <div class="col-md-6 ">
                    @include('lubot::bd.component.bd-template')
                </div>
            </div>

            <div class="bd_container color" style="margin-top:40px;">
                @include('lubot::bd.component.campana_pro')
            </div>
        </div>


    </div>


    <style>
     
        .container_1 {
            display: flex;
        }

        .color {
            background-color: #ffffff;
            border-radius: 10px;
            margin-left: 30px;
        }

        .contain-bd {

            max-width: 1007px;
        }

        .list_db {
            cursor: pointer;
            transition: all .300s linear;
        }

        .list_db:hover {
            background: #f2f2f2;

        }

        @media (max-width:1500px) {
            .content-wrapper {
                width: 83vw !important;

            }

            .container_1 {

                padding-left: 60px;

                display: flex;
                flex-direction: column;
            }

            .contain-bd {

                max-width: 63%;

                overflow: hidden;
            }
        }
    </style>
@endsection
