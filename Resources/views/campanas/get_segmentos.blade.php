<div class="input-row">
                                               
    <div class="col-md-2">
        <x-forms.select fieldId="remind_type"  fieldName="pais[]" search="true">
            @foreach ($paises as $pais)
                <option value="{{$pais['id']}}">{{$pais['nombre']}}</option>
            @endforeach
        </x-forms.select>
    </div>
    <div class="col-md-2">
        <x-forms.select  fieldId="remind_type"   fieldName="ciudad[]" search="true" >
         
        </x-forms.select>
    </div>
    <div class="col-md-2">
        <x-forms.select fieldId="remind_type"  fieldName="barrio[]"   search="true">
            @foreach ($barrios as $barrio)
                <option value="{{$barrio['id']}}">{{$barrio['nombre']}}</option>
            @endforeach
        </x-forms.select>
    </div>
    <div class="col-md-2">
        <x-forms.select  fieldId="remind_type" fieldName="segmento[]" search="true">
            @foreach ($segmentos as $segmento)
                <option value="{{$segmento['id']}}">{{$segmento['nombre']}}</option>
            @endforeach
         </x-forms.select>
    </div>
    <div class="col-md-3">
        <x-forms.text class="mr-0 mr-lg-2 mr-md-2" fieldPlaceholder="Cantidad" fieldLabel="" fieldName="cantidad"
         fieldRequired="true" fieldId="contract_prefix" fieldValue="" />
    </div>
    <div class="col-md-3" style="position: relative; bottom:-45px">  
        <button class="btn btn-success" type="button" onclick="addRow(this)">+</button>
    </div>
   
</div>

