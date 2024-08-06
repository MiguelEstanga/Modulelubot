@extends('layouts.app')
@section('content')
    <div class="containt-wrapper">
        <div class="container">
            <table class="table table-string">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>nombre</td>
                        <td>direccion</td>
                        <td>telefono</td>
                        <td>url_web </td>
                        <td>rating</td>
                        <td>descripcion </td>
                        <td>mensage_inicial_enviado </td>
                        <td>tipo_de_negocio_id</td>
                        <td>pai_id</td>
                        <td>ciudad_id</td>
                        <td>barrio_id</td>
    
    
                    </tr>
                </thead>
                <tbody>
                   @foreach($db_data as $items )
                        <tr>
                            <td>{{$items['id']}}</td>
                            <td>{{$items['nombre']}}</td>
                            <td>{{$items['direccion ']}}</td>
                            <td>{{$items['telefono']}}</td>
                            <td>{{$items['url_web ']}}</td>
                            <td>{{$items['rating']}}</td>
                            <td>{{$items['descripcion ']}}</td>
                            <td>{{$items['mensage_inicial_enviado ']}}</td>
                            <td>{{$items['tipo_de_negocio_id']}}</td>
                            <td>{{$items['pai_id']}}</td>
                            <td>{{$items['ciudad_id']}}</td>
                            <td>{{$items['barrio_id']}}</td>
    
    
                        </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <style>
        .list_db{
            cursor:pointer;
            transition: all .300s   linear;
        }
        .list_db:hover{
            background: #f2f2f2;
        }
    </style>
@endsection
