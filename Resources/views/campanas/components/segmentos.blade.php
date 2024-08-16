
    <div class="_container">

        <div id="input-container">
            <div class="input-row row">
                <div class="col-md-2 ">
                    <select name="pais[]" onchange="loadciudad(this)" class="form-control selectpicker"  data-live-search="true">
                        <option value="0">Todos</option>
                        @foreach ($paises as $pais)
                            <option value="{{ $pais['id'] }}">{{ $pais['nombre'] }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-2">
                    <select name="ciudad[]" onchange="loadBarrios(this)" class="form-control selectpicker ciudad-select" data-live-search="true" >
                        <option value="0">Todos</option>
                    </select>
                </div>
                <div class="col-md-2" id='conten_barrios_dinamicos'>
                    <select name="barrio[]" id='barrio_select1' class="form-control selectpicker barrio-select" data-live-search="true">
                        
                    </select>
                </div> 

                <div class="col-md-4 cantidad">
                    <span>Cantidad: </span>
                    <input type="number" 
                        style=" 
                            width: 71px!important;  
                            height: 30px!important;
                        "
                        class="__cantidad" 
                        placeholder="Cantidad" name="cantidad[]">
                </div>
                <div class="col-md-2" style="position:relative; right: -40px;">
                    <button class="btn btn-success" type="button" onclick="addRow()">
                        +
                    </button>

                </div>
            </div>
        </div>
    </div>


<style>
    ._container{
     
        height: auto;
    }
    .__cantidad{
      
    }
    .cantidad {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }
</style>
