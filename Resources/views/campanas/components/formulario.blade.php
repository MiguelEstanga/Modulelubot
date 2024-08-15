@include('lubot::campanas.components.activar_rc')
@include('lubot::campanas.components.preguntas_respuestas')
<div class="container_info container-auto">
    <div class="fuente-titulo-xdefecto">
        Configura tu campaña
    </div>
    <div>
        <input class="custom_input" type="text" placeholder="Nombre de tu campaña" name="nombre_campana">
        <div class="text-layout" style="position: relative; top:-10px;">
            ¿Qué tipo de clientes te interesan?
        </div>
        <div class="">
            <select name="segmento" class="form-control selectpicker ">
                @foreach ($segmentos as $segmento)
                    <option value="{{ $segmento['id'] }}">{{ $segmento['nombre'] }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <div class="divider" style="margin-top:30px;"></div>
            <div class="text-layout">
                ¿Dónde quieres que encuentre clientes para ti?
            </div>
            <div>
                @include('lubot::campanas.components.segmentos')
            </div>
            <div class="divider" style="margin-top:30px;"></div>
            <div class="frecuencia">
                <span class="text-layout">Frecuencia de envío</span>
                <input class="" type="number" name="frecuencia" style="width: 75px!important; height:35px!important;">
                <span class="text-layout">cada</span>
                <div class="col-md-2">
                    <select name="temporalidad" class="form-control selectpicker">

                        <option value="dia"> dia</option>

                    </select>
                </div>
            </div>
            <div class="frecuencia">
                <span class="text-layout">Selecciona tu plan</span>
                <div class="col-md-2">
                    <select name="plan" class=" selectpicker" style="width:284px!important;">

                        <option value=" 30 Envíos  PRO - $10 USD"> 30 Envíos PRO - $10 USD</option>

                    </select>
                </div>


            </div>
            <div class="btn_container" id="activar_rc">
                <button type="submit" class="btn btn-envio">Pagar y Enviar Campaña</button>
            </div>
        </div>

    </div>
</div>
<style>
    .btn_container {
        width: 100%;
        display: flex;
        justify-content: end;
        align-items: flex-end;
    }

    .frecuencia {
        display: flex;
        justify-content: start;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }

    .container-auto {


        height: auto !important;
        padding: 30px;
    }
</style>
<script>
    // Crea un nuevo objeto FormData
    const formData = new FormData();

    // Función para actualizar el FormData
    function addRow(button) {
    var newRow = `
    <div class="input-row row" style='margin-top:10px;'>
        <div class="col-md-2">
            <select name="pais[]" class="form-control selectpicker" data-live-search="true">
                @foreach ($paises as $pais)
                    <option value="{{ $pais['id'] }}">{{ $pais['nombre'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="ciudad[]" class="form-control selectpicker ciudad-select" data-live-search="true">
                @foreach ($ciudades as $ciudad)
                    <option value="{{ $ciudad['id'] }}">{{ $ciudad['nombre'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="barrio[]" class="form-control selectpicker barrio-select" data-live-search="true">
                <option value="">Seleccione un barrio</option>
            </select>
        </div>
        <div class="col-md-4 cantidad">
            <span>Cantidad: </span>
            <input type="number" class="form-control" style="width: 71px!important; height:37px!important;" placeholder="Cantidad" name="cantidad[]">
        </div>
        <div class="col-md-2" style="position:relative; right: -40px;">
            <button class="btn " type="button" onclick="removeRow(this)">-</button>
            <button class="btn " type="button" onclick="addRow(this)">+</button>
        </div>
    </div>`;

    // Añadir la nueva fila al contenedor
    const newFieldsContainer = document.createElement('div');
    newFieldsContainer.innerHTML = newRow;
    document.getElementById('input-container').appendChild(newFieldsContainer);

    // Inicializar los selectpicker en la nueva fila
    $('.selectpicker').selectpicker('refresh');

    // Añadir event listeners a los nuevos campos
    const newFields = newFieldsContainer.querySelectorAll('input, select, textarea');
    addEventListenersToNewFields(newFields);

    // Añadir event listener para cargar los barrios cuando cambie la ciudad
    const ciudadSelect = newFieldsContainer.querySelector('.ciudad-select');
    const barrioSelect = newFieldsContainer.querySelector('.barrio-select');
    ciudadSelect.addEventListener('change', function() {
        loadBarrios(ciudadSelect, barrioSelect);
    });

    // Quitar el botón de agregar de la fila anterior
    $(button).remove();
}

function loadBarrios(ciudadSelect, barrioSelect) {
    const ciudadId = ciudadSelect.value;

    if (ciudadId) {
        fetch(`https://lubot.healtheworld.com.co/api/barrios/${ciudadId}`)
            .then(response => response.json())
            .then(data => {
                // Limpiar el select de barrios actual
                barrioSelect.innerHTML = '';

                // Agregar una opción por defecto
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Seleccione un barrio';
                barrioSelect.appendChild(defaultOption);

                // Agregar las nuevas opciones de barrios
                data.forEach(barrio => {
                    const option = document.createElement('option');
                    option.value = barrio.id;
                    option.textContent = barrio.nombre;
                    barrioSelect.appendChild(option);
                });

                // Refrescar el selectpicker
                $(barrioSelect).selectpicker('refresh');
            })
            .catch(error => {
                console.error('Error al cargar los barrios:', error);
            });
    } else {
        // Si no hay ciudad seleccionada, limpiar el select de barrios
        barrioSelect.innerHTML = '<option value="">Seleccione un barrio</option>';
        $(barrioSelect).selectpicker('refresh');
    }
}





    function removeRow(button) {
        // Eliminar la fila correspondiente
        $(button).closest('.input-row').remove();

        // Asegurar que siempre haya un botón de agregar en la última fila
        var lastRow = $('#input-container .input-row:last');
        if (!lastRow.find('.btn-success').length) {
            lastRow.find('.col-md-1').append(
                '<button class="btn btn-success" type="button" onclick="addRow(this)">+</button>');
        }

        // Actualizar el FormData después de eliminar la fila
        updateFormData();
    }

    // Funciones para agregar y eliminar filas de preguntas y respuestas

    function addForm(button) {
        // Crear una nueva fila con los mismos elementos que la original
        var newForm = `
    <div class="preguntas_respuesta">
        <div class="col-md-5">
            <input type="text" class="custom_input margin-none" placeholder="Si el cliente dice:" name="pregunta[]">
        </div>
        <div class="col-md-5">
            <input type="text" class="custom_input margin-none" placeholder="ubot debería responder:" name="respuesta[]">
        </div>
        <div class="">
            <button class="btn btn-success" type="button" onclick="addForm(this)">+</button>
            <button class="btn btn-danger" type="button" onclick="removeForm(this)">-</button>
        </div>
    </div>
    `;

        // Añadir la nueva fila al contenedor
        const formContainer = document.getElementById('form-container');
        formContainer.insertAdjacentHTML('beforeend', newForm);

        // Eliminar el botón "+" de la fila anterior
        const previousButton = button.parentElement.querySelector('button[onclick^="addForm"]');
        if (previousButton) previousButton.remove();

        // Añadir event listeners a los nuevos campos
        const newFields = formContainer.querySelectorAll('input, select, textarea');
      //  addEventListenersToNewFields(newFields);

        // Actualizar el FormData después de añadir la fila
        updateFormData();
    }

    function removeForm(button) {
        // Eliminar la fila correspondiente
        const rowToRemove = button.closest('.preguntas_respuesta');
        rowToRemove.remove();

        // Asegurar que siempre haya un botón "+" en la última fila
        const formContainer = document.getElementById('form-container');
        const lastRow = formContainer.querySelector('.preguntas_respuesta:last-child div:last-child');
        if (!lastRow.querySelector('button[onclick^="addForm"]')) {
            lastRow.insertAdjacentHTML('beforeend',
                '<button class="btn btn-success" type="button" onclick="addForm(this)">+</button>');
        }

        // Actualizar el FormData después de eliminar la fila
        updateFormData();
    }

    function enviar_campana(id) 
    {
        // Asegúrate de que la ruta sea interpolada correctamente en el Blade.
        const url = `{{ route('campanas.stores') }}`;
        console.log('form')
        const data =  JSON.parse (localStorage.getItem('formData'))
        if (data) {
            if (typeof data.paises === "string") data.paises = JSON.parse(data.paises);
            if (typeof data.ciudades === "string") data.ciudades = JSON.parse(data.ciudades);
            if (typeof data.barrios === "string") data.barrios = JSON.parse(data.barrios);
            if (typeof data.cantidades === "string") data.cantidades = JSON.parse(data.cantidades);
            if (typeof data.preguntas_respuestas === "string") data.preguntas_respuestas = JSON.parse(data
                .preguntas_respuestas);
        }
        console.log(data)
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content') // Añadir el token CSRF
                },
                body:JSON.stringify(data)
            })
            .then(response => {

                return response.json();
            })
            .then(responseData => {
                if(responseData.status === 200 ) { 
                    modal_preguntas_y_respuesta.style.display= 'none'
                    
                     alert('listo')
                }
                console.log(responseData);
                // Aquí puedes manejar la respuesta del servidor
            })
            .catch(error => console.error('Error:', error));
    }


   
</script>

