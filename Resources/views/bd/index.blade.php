@extends('layouts.app')
@section('content')
    @include('lubot::css.css')

    <div class="content-wrapper row" >
        @include('lubot::bd.component.helper_user')

        <div class="contain-bd" style="gap: 10px;">
            <div class="bd_container row" >
                <div class="col-md-6 p-10">
                    @include('lubot::bd.component.formulario')
                </div>
                <div class="col-md-6">
                    @include('lubot::bd.component.bd-template')
                </div>
            </div>

            <div class="bd_container" style="margin-top:40px;" >
                @include('lubot::bd.component.campana_pro')
            </div>
        </div>


    </div>


    <style>
        .contain-bd{
           
            max-width: 1007px;
        }
        .list_db {
            cursor: pointer;
            transition: all .300s linear;
        }

        .list_db:hover {
            background: #f2f2f2;
           
        }

        .bd_container {
           
        }
    </style>
@endsection
