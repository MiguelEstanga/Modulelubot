@extends('layouts.app')



@section('content')
   @if(in_array('admin', user_roles()))
            
<div class="content-wrapper" >
                    <form action="{{route('lubot.activacion')}}" method="post" class=""  autocomplete="on">
                         
                           @csrf
                            @method("post")
                           <div class="col-lg-12 row">
                                <div class="col-md-2 form-group my-3">
                                    <label for="" class="f-14 text-dark-grey mb-12">
                                        Código <sup class="f-14 mr-1">*</sup>
                                    </label>
                                    <select class="form-control selectpicker" data-live-search="true" style="margin-top: 50px;" name="codigo">
                                        @foreach($codigos as $codigo)
                                            <option value="{{$codigo->id}}">{{$codigo->codigos}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-10">
                                    <x-forms.text class="mr-0 mr-lg-2 mr-md-2" fieldLabel="Numero de telefono" fieldPlaceholder="Numero de telefono" fieldName="numero"
                                    fieldRequired="true" fieldId="contract_prefix" :fieldValue="$numero" />
                                </div>
                            
                               
                          
                           </div>
                           @if($numero !== null)
                            <div class="container" style="margin: 10px">
                                <div class="cntainer" id="code_ws_container" >
                                    code: <span id="code"></span>
                                </div>
                               
                            </div>  
                            <div class="container" id="code_container" style="margin: 10px">
                                <div class="cntainer" >
                                    code: <span id="code_rc"></span>
                                </div>
                            </div>  
                            
                            <div class="container" style="margin: 10px" >
                                <div class="tiempo" id="tiempo">
                                    tiempo
                                </div>
                            </div>
                           @endif
                           <div class="">
                             <button class="btn btn-success">
                                @if($activacion === true)
                                    Actulizar datos
                                @else
                                    Activar 
                                @endif
                             </button>
                           </div>
                    </form>
</div>
            <!-- Buttons End -->
    
    <script>
        function code_ws()
        {
            fetch(`{{route('lubot.default_compania')}}`)
            .then(response => response.json())
            .then(data => {

                if( data.code_ws === null && data.code_rc === null ) tiempo.style.display = 'none';
                // Verificar si los datos están definidos y no están vacíos
                if (data.code_ws) {
                    document.getElementById('code').innerHTML = data.code_ws;
                    document.getElementById('code_ws_container').style.display = 'flex';
                } else {
                    // Ocultar el div si el dato está vacío
                    document.getElementById('code').style.display = 'none';
                    document.getElementById('code_ws_container').style.display = 'flex';
                }

                if (data.code_rc != null ) {
                    document.getElementById('code_rc').innerHTML = data.code_rc;
                    document.getElementById('code_container').style.display = 'flex';
                } else {
                  
                    document.getElementById('code_container').style.display = 'none';
                }

                console.log(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });

        }
        function cuentaRegresiva() {
            const tiempoTotal = 8;
            let tiempoRestante = tiempoTotal;
            const elementoTiempo = document.getElementById('tiempo');

            const intervalo = setInterval(() => {
                tiempoRestante--;
                elementoTiempo.textContent = `Tiempo restante: ${tiempoRestante} segundos`;

                if (tiempoRestante === 0) {
                clearInterval(intervalo);
                // Realizar la petición GET aquí
                code_ws()

                // Reiniciar la cuenta regresiva
                cuentaRegresiva();
                }
            }, 1000);
        }
        code_ws();
        cuentaRegresiva();
        
    </script>
</div>
 @endif
    <div class="container-fluid"></div>
@endsection
<style>
    
</style>


