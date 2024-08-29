<div class="container">
    <form action="{{route('bd.store')}}" method="POST" enctype="multipart/form-data" >
        @csrf

        <div class="container">
            <x-forms.text class="mr-0 mr-lg-2 mr-md-2" fieldLabel="Nombre de la base de datos" fieldPlaceholder="Nombre de la base de datos" fieldName="bd_name"
            fieldRequired="true" fieldId="contract_prefix" fieldValue="" />
        </div>
        
        <div class="container">
            <x-forms.file class="mr-0 mr-lg-2 mr-md-2" fieldLabel="Nombre de la base de datos" fieldPlaceholder="base de datos" fieldName="file"
            fieldRequired="true" fieldId="contract_prefix" fieldValue="" />
          
        </div>
        <div class="container" style="margin-top:30px;">
            <button class="btn btn-success" style="width: 100%!important;">
                crear
            </button>
        </div>
    </form>
</div>