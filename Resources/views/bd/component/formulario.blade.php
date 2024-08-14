<h2 class="fuente-titulo-xdefecto">
    Carga tu Base de datos
</h2>
<div class="container">
    <form action="{{route('bd.store')}}" method="POST" enctype="multipart/form-data" >
        @csrf
        <div class="container_file">
            <div class="container">
                <x-forms.file class="mr-0 mr-lg-2 mr-md-2" fieldLabel="" fieldPlaceholder="base de datos" fieldName="file"
                fieldRequired="true" fieldId="contract_prefix" fieldValue="" />
            </div>
        </div>
        <div>
            <a class="color-fondo-primario btn color-segundario-text"  href="">
                Descargar archivo de ejemplo
            </a>
        </div>
        <div class="p-10">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault" style="padding: 5px;">
                    Aceptas que tienes permiso para usar esta base de datos
                </label>
              </div>
        </div>
        <!--div class="container" style="margin-top:30px;">
            <button class="btn btn-success" style="width: 100%!important;">
                crear
            </button>
        </div-->
    </form>
</div>
<style>
    .container_file{
        width: 436px;
        height: 246px;
       
    }
</style>