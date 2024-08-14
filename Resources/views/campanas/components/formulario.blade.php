@include('lubot::campanas.components.activar_rc')
@include('lubot::campanas.components.preguntas_respuestas')
<div class="container_info container-auto">
    <div class="fuente-titulo-xdefecto">
        Configura tu campaña
    </div>
    <div>
        <input class="custom_input" type="text" placeholder="Nombre de tu campaña" name="nombre_campana">
        <div class="text-layout">
            ¿Qué tipo de clientes te interesan?
        </div>
        <div class="custom_input">
            <select name="segmento" class="form-control selectpicker custom_input">
                @foreach ($segmentos as $segmento)
                    <option value="{{ $segmento['id'] }}">{{ $segmento['nombre'] }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <div class="divider"></div>
            <div class="text-layout">
                ¿Dónde quieres que encuentre clientes para ti?
            </div>
            <div>
                @include('lubot::campanas.components.segmentos')
            </div>
            <div class="divider"></div>
            <div class="frecuencia">
                <span class="text-layout">Frecuencia de envío</span>
                <input class="input_number" type="number" name="frecuencia">
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
                    <select name="plan" class="form-control selectpicker">

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
<form action=""></form>
<script>
    // Crea un nuevo objeto FormData
    const formData = new FormData();

    // Función para actualizar el FormData
    function updateFormData() {
        // Limpiar el formData antes de agregar nuevos valores
        formData.delete('nombre_campana');
        formData.delete('segmento');
        formData.delete('frecuencia');
        formData.delete('temporalidad');
        formData.delete('plan');
        formData.delete('paises');
        formData.delete('ciudades');
        formData.delete('barrios');
        formData.delete('cantidades');
        formData.delete('preguntas_respuestas');
        formData.delete('como_me_llamo');
        formData.delete('objetivo_lubot');
        formData.delete('spbre_la_empresa');

        // Capturar los valores individuales
        formData.append('nombre_campana', document.querySelector('input[name="nombre_campana"]').value);
        formData.append('segmento', document.querySelector('select[name="segmento"]').value);
        formData.append('frecuencia', document.querySelector('input[name="frecuencia"]').value);
        formData.append('temporalidad', document.querySelector('select[name="temporalidad"]').value);
        formData.append('plan', document.querySelector('select[name="plan"]').value);

        // Capturar nuevos campos
        formData.append('como_me_llamo', document.querySelector('input[name="como_me_llamo"]').value);
        formData.append('objetivo_lubot', document.querySelector('select[name="objetivo_lubot"]').value);
        formData.append('spbre_la_empresa', document.querySelector('textarea[name="spbre_la_empresa"]').value);

        // Capturar los valores que pueden repetirse y agruparlos en arrays de objetos
        let paisesArray = [];
        document.querySelectorAll('select[name="pais[]"]').forEach(select => {
            paisesArray.push({
                id: select.value
            });
        });
        formData.append('paises', JSON.stringify(paisesArray));

        let ciudadesArray = [];
        document.querySelectorAll('select[name="ciudad[]"]').forEach(select => {
            ciudadesArray.push({
                id: select.value
            });
        });
        formData.append('ciudades', JSON.stringify(ciudadesArray));

        let barriosArray = [];
        document.querySelectorAll('select[name="barrio[]"]').forEach(select => {
            barriosArray.push({
                id: select.value
            });
        });
        formData.append('barrios', JSON.stringify(barriosArray));

        let cantidadesArray = [];
        document.querySelectorAll('input[name="cantidad[]"]').forEach(input => {
            cantidadesArray.push({
                cantidad: input.value
            });
        });
        formData.append('cantidades', JSON.stringify(cantidadesArray));

        // Capturar preguntas y respuestas en un array de objetos
        let preguntasRespuestasArray = [];
        const preguntas = document.querySelectorAll('input[name="pregunta[]"]');
        const respuestas = document.querySelectorAll('input[name="respuesta[]"]');

        preguntas.forEach((input, index) => {
            let pregunta = input.value;
            let respuesta = respuestas[index].value;
            preguntasRespuestasArray.push({
                pregunta: pregunta,
                respuesta: respuesta
            });
        });

        formData.append('preguntas_respuestas', JSON.stringify(preguntasRespuestasArray));

        // Convertir el FormData a un objeto para almacenarlo en localStorage
        let formDataObject = {};
        formData.forEach((value, key) => {
            formDataObject[key] = value;
        });

        // Guardar el objeto en localStorage
        localStorage.setItem('formData', JSON.stringify(formDataObject));

        console.log('FormData actualizado y guardado en localStorage:',
            formDataObject); // Mostrar el FormData actualizado
    }


    // Función para agregar event listeners a los nuevos campos
    function addEventListenersToNewFields(fields) {
        fields.forEach(field => {
            field.addEventListener('input', updateFormData);
            field.addEventListener('change', updateFormData);
        });
    }

    // Llamada inicial para capturar los valores existentes en los campos
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('input', updateFormData);
        element.addEventListener('change', updateFormData);
    });

    // Llamar a la función una vez para capturar los valores iniciales (si los hay)
    updateFormData();

    // Función para añadir una nueva fila en el formulario (duplicar)
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
            <select name="ciudad[]" class="form-control selectpicker" data-live-search="true">
                @foreach ($ciudades as $ciudad)
                    <option value="{{ $ciudad['id'] }}">{{ $ciudad['nombre'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="barrio[]" class="form-control selectpicker" data-live-search="true">
                @foreach ($barrios as $barrio)
                    <option value="{{ $barrio['id'] }}">{{ $barrio['nombre'] }}</option>
                @endforeach
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

        // Quitar el botón de agregar de la fila anterior
        $(button).remove();
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
        addEventListenersToNewFields(newFields);

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


    function sendDataFromLocalStorage() {
        // Paso 1: Recuperar los datos del localStorage
        const data = JSON.parse(localStorage.getItem('formData'));

        // Verificar que data no sea null
        if (!data) {
            console.error('No se encontró "formData" en localStorage.');
            return;
        }

        // Paso 2: Crear un formulario
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/ruta/a/tu/controlador'; // Reemplaza con la ruta correcta en tu servidor

        // Agregar el token CSRF como un campo oculto
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_csrf'; // Nombre del campo que espera tu servidor
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        // Paso 3: Agregar campos ocultos con los datos
        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                if (Array.isArray(data[key])) {
                    data[key].forEach(value => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `${key}[]`;
                        input.value = value;
                        form.appendChild(input);
                    });
                } else {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = data[key];
                    form.appendChild(input);
                }
            }
        }

        // Paso 4: Agregar el formulario al cuerpo del documento
        document.body.appendChild(form);

        // Paso 5: Enviar el formulario
        form.submit();

        // Paso 6: Opcionalmente, eliminar el formulario después de enviarlo
        document.body.removeChild(form);
    }
</script>
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
        padding: 20px;
    }
</style>