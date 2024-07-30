@extends('layouts.app')



@section('content')
   @if(in_array('admin', user_roles()))
            
<div class="content-wrapper" >
                    <form action="{{route('lubot.activacion')}}" method="post" class=""  autocomplete="on">
                         
                           @csrf
                            @method("post")
                           <div class="col-lg-12">
                                <x-forms.text class="mr-0 mr-lg-2 mr-md-2" fieldLabel="Numero de telefono" fieldPlaceholder="Numero de telefono" fieldName="numero"
                                fieldRequired="true" fieldId="contract_prefix" :fieldValue="$numero" />
                               
                          
                           </div>
                           @if($numero !== null)
                            <div class="container" style="margin: 10px">
                                <div class="cntainer" >
                                    code: <span id="code"></span>
                                </div>
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
        function cuentaRegresiva() {
            const tiempoTotal = 40;
            let tiempoRestante = tiempoTotal;
            const elementoTiempo = document.getElementById('tiempo');

            const intervalo = setInterval(() => {
                tiempoRestante--;
                elementoTiempo.textContent = `Tiempo restante: ${tiempoRestante} segundos`;

                if (tiempoRestante === 0) {
                clearInterval(intervalo);
                // Realizar la petición GET aquí
                fetch(`{{route('lubot.default_compania')}}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('code').innerHTML = data.code_ws
                    // Actualizar la interfaz con los datos de la respuesta
                    console.log(data);
                        
                    })
                    .catch(error => {
                    console.error('Error:', error);
                    });

                // Reiniciar la cuenta regresiva
                cuentaRegresiva();
                }
            }, 1000);
        }

        cuentaRegresiva();
    </script>
</div>
 @endif
    <div class="container-fluid"></div>
@endsection
<style>
    
</style>


