<div class="d-flex flex-column w-tables rounded mt-3 bg-white" style="padding: 10px;">
    <div class="container">

        <div id="input-container">
            <div class="input-row row">
                <div class="col-md-2 ">
                    <select name="pais[]" class="form-control selectpicker" data-live-search="true">
                        @foreach ($paises as $pais)
                            <option value="{{ $pais['id'] }}">{{ $pais['nombre'] }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-2">
                    <select name="ciudad[]" class="form-control selectpicker">
                        @foreach ($ciudades as $ciudad)
                            <option value="{{ $ciudad['id'] }}">{{ $ciudad['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="barrio[]" class="form-control selectpicker">
                        @foreach ($barrios as $barrio)
                            <option value="{{ $barrio['id'] }}">{{ $barrio['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 cantidad">
                    <span>Cantidad: </span>
                    <input type="number" class="form-control" style="width: 71px!important; height:37px!important;"
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

</div>
<style>
    .cantidad {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }
</style>
