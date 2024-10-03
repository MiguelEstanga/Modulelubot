@include('lubot::campanas.components.activar_rc')
@include('lubot::campanas.components.preguntas_respuestas')
@php
    use Modules\Lubot\Http\Controllers\HelperController;
@endphp
<div class="container_info container-auto">
    <div class="fuente-titulo-xdefecto">
        Configura tu campaña
    </div>
    <div>
        <input class="custom_input" type="text" placeholder="Nombre de tu campaña {{ $bd_externar }}"
            name="nombre_campana" required>
        @if ($bd_externar == 0)
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
        @endif

        <div>
            @if ($bd_externar == 0)
                <div class="divider" style="margin-top:30px;"></div>
                <div class="text-layout">
                    ¿Dónde quieres que encuentre clientes para ti?
                </div>
                <div>
                    @include('lubot::campanas.components.segmentos')
                </div>
                <div class="divider" style="margin-top:30px;"></div>
            @endif

            <div class="frecuencia">
                <span class="text-layout">Frecuencia de envío</span>
                <input class="" type="number" name="frecuencia"
                    style="width: 75px!important; height:35px!important;">
                <span class="text-layout">cada</span>
                <div class="col-md-2">
                    <select name="temporalidad" class="form-control selectpicker">
                        <!--option value="minutes">Minutos Solo para desarrollo</option>
                        <option value="hours"> Horas</option-->
                        <option value="days">Dia</option>
                        <option value="weeks">Semanas</option>
                    </select>
                </div>
            </div>
            <div class="frecuencia">
                <span class="text-layout">Selecciona tu plan</span>
                <div class="">
                    <select name="plan" class=" selectpicker" style="width:284px!important;">
                        <option value=" 30 Envíos  PRO - $10 USD"> 30 Envíos PRO - $10 USD</option>
                    </select>
                </div>


            </div>
            <div class="btn_container" style="margin-top: 30px;">
                <button onclick="modal_preguntas_respuest()" type="submit" class="btn btn-envio">Pagar y Enviar
                    Campaña</button>
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
    console.log('form data en local', localStorage.getItem('formData'))
    let bd_externar = {{ $bd_externar }}

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

        formData.append('nombre_campana', document.querySelector('input[name="nombre_campana"]').value);
        formData.append('temporalidad', document.querySelector('select[name="temporalidad"]').value);
        formData.append('frecuencia', document.querySelector('input[name="frecuencia"]').value);
        formData.append('objetivo_lubot', document.querySelector('select[name="objetivo_lubot"]').value);
        formData.append('spbre_la_empresa', document.querySelector('textarea[name="spbre_la_empresa"]').value);
        formData.append('plan', document.querySelector('select[name="plan"]').value);
        // Capturar nuevos campos
        formData.append('como_me_llamo', document.querySelector('input[name="como_me_llamo"]').value);
        if (bd_externar === 0) {

            formData.append('segmento', document.querySelector('select[name="segmento"]').value);

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

        }



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

        console.log('FormData actualizado y guardado en localStorage:', formDataObject);
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
    let totalCredits = 0;
    const maxCredits = 30;
    // Función para añadir una nueva fila en el formulario (duplicar)
    function addRow(button) {
        // Sumar las cantidades existentes
        totalCredits = 0;
        document.querySelectorAll('input[name="cantidad[]"]').forEach(input => {
            totalCredits += parseInt(input.value) || 0;
        });

        if (totalCredits >= maxCredits) {
            alert('No puedes agregar más filas porque se ha alcanzado el máximo de 30 créditos.');
            return;
        }

        var newRow = `
            <div class="input-row row" style='margin-top:10px;'>
                <div class="col-md-2">
                    <select name="pais[]"   onchange="loadciudad(this)" class="form-control selectpicker" data-live-search="true">
                        <option value="0">Todos</option>
                        @foreach ($paises as $pais)
                            <option value="{{ $pais['id'] }}">{{ $pais['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="ciudad[]" onchange="loadBarrios(this)" class="form-control selectpicker" data-live-search="true">
                        <option value="0">Todos</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="barrio[]" class="form-control selectpicker barrio-select" data-live-search="true">
                        <option value="0">Todos</option>
                    </select>
                </div>
                <div class="col-md-4 cantidad">
                    <span>Cantidad: </span>
                    <input type="number" class="form-control" style="width: 71px!important; height:37px!important;" placeholder="Cantidad" name="cantidad[]" onchange="validateCredits(this)">
                </div>
                <div class="col-md-2" style="position:relative; right: -40px;">
                    <button class="btn btn-danger" type="button" onclick="removeRow(this)">-</button>
                    <button class="btn btn-success" type="button" onclick="addRow(this)">+</button>
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


    function validateCredits(input) {
        // Sumar todas las cantidades actuales
        totalCredits = 0;
        document.querySelectorAll('input[name="cantidad[]"]').forEach(input => {
            totalCredits += parseInt(input.value) || 0;
        });

        if (totalCredits > maxCredits) {
            const availableCredits = maxCredits - (totalCredits - parseInt(input.value || 0));
            if (availableCredits < 0) {
                input.value = '';
                alert('No puedes agregar más créditos. Solo te quedan ' + (maxCredits - totalCredits + parseInt(input
                    .value || 0)) + ' créditos disponibles.');
            } else {
                input.value = availableCredits;
                alert('Solo te quedan ' + availableCredits + ' créditos disponibles.');
            }
        }

        // Actualizar el total de créditos
        totalCredits = 0;
        document.querySelectorAll('input[name="cantidad[]"]').forEach(input => {
            totalCredits += parseInt(input.value) || 0;
        });

        if (totalCredits >= maxCredits) {
            // Desactivar todos los botones de agregar si se alcanzan los 30 créditos
            document.querySelectorAll('.btn-success').forEach(btn => {
                btn.disabled = true;
            });
        }
    }

    function removeRow(button) {
        const row = button.closest('.input-row');

        // Restar la cantidad eliminada del total de créditos
        const cantidad = row.querySelector('input[name="cantidad[]"]').value;
        totalCredits -= parseInt(cantidad) || 0;

        // Eliminar la fila
        row.remove();

        // Reactivar los botones de agregar si es posible
        if (totalCredits < maxCredits) {
            document.querySelectorAll('.btn-success').forEach(btn => {
                btn.disabled = false;
            });
        }
        updateFormData();
    }


    function loadOptions(selectElement, endpoint, nextSelectName, allOptionText = "Todos") {
        const id = selectElement.value;
        console.log('id de loadOptions' ,id)
        const parentRow = selectElement.closest('.input-row');
        const nextSelect = parentRow.querySelector(`select[name="${nextSelectName}[]"]`);
        console.log(nextSelectName)
        console.log(`${endpoint}/${id}`)
        if (id === '0') {
            // Seleccionó "Todos"
            nextSelect.innerHTML = `<option value="0">${allOptionText}</option>`;
            nextSelect.disabled = true;
            $(nextSelect).selectpicker('refresh');
        } else {
            // Cargar opciones basadas en el ID seleccionado
            fetch(`${endpoint}/${id}`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer 8lbA52huHchhbswplKpH0OcUsr+QIgFZRkfdNsYUGhk=`,
                        'ngrok-skip-browser-warning': 'true',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('data')
                    console.log(data)
                    nextSelect.innerHTML = `<option value="0">${allOptionText}</option>`;
                    nextSelect.disabled = false;
                    console.log('carga')
                    data.data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.nombre;
                        nextSelect.appendChild(option);
                    });

                    $(nextSelect).selectpicker('refresh');
                })
                .catch(error => {
                    console.error(`Error al cargar opciones desde ${endpoint}:`, error);
                });
        }

        updateFormData(); // Actualizar el almacenamiento después de cargar las opciones
    }

    function loadciudad(paisSelect) {
        console.log('pais seleccionado' ,paisSelect.value)

        loadOptions(paisSelect, `{{ $loadCiudad }}`, 'ciudad');
        console.log(`{{ $loadCiudad }}/${paisSelect.value}`)
        console.log("test cargando ciudad")
        const parentRow = paisSelect.closest('.input-row');
        const barrioSelect = parentRow.querySelector('select[name="barrio[]"]');

        if (paisSelect.value === '0') {
            // Si selecciona "Todos" en país, también selecciona "Todos" en barrio y lo bloquea
            barrioSelect.innerHTML = `<option value="0">Todos</option>`;
            barrioSelect.disabled = true;
            $(barrioSelect).selectpicker('refresh');
        } else {
            barrioSelect.innerHTML = ''; // Limpiar barrios cuando se selecciona un nuevo país
            barrioSelect.disabled = false; // Habilitar el select de barrios
            $(barrioSelect).selectpicker('refresh');
        }
    }

    function loadBarrios(ciudadSelect) {
        console.log('test cargando barrios')
        console.log(ciudadSelect)
        loadOptions(ciudadSelect, `{{ $loadBarrios }}`, 'barrio');
    }




    // Funciones para agregar y eliminar filas de preguntas y respuestas

    function addForm(button) {
        // Crear una nueva fila con los mismos elementos que la original
        var newForm = `
            <div class="preguntas_respuesta">
                <div class=""">
                    <input type="text" class="custom_input margin-none" placeholder="Si el cliente dice:" name="pregunta[]">
                </div>
                <div class="">
                    <input type="text" class="custom_input margin-none" placeholder="Lubot debería responder:" name="respuesta[]">
                </div>
                <div class="container_agregar_borrar">
                    <button class="btn btn-success btn_mas_menos" type="button" onclick="addForm(this)">+</button>
                    <button class="btn btn-danger btn_mas_menos" type="button" onclick="removeForm(this)">-</button>
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



    function comprobacion() {
        fetch(`{{ route('lubot.default_compania') }}`)
            .then(response => response.json())
            .then(response => {

                if (parseInt(response.estado_rc) === 2 && response.code_rc != null) {
                    console.log('proceso completado')
                    activar_campana.style.display = "flex"
                    container_codigo_rc.style.display = 'none'
                    __activar_rc.style.display = "none"
                    console.log('el proceso de rc se a completado exitosamente')
                }

                console.log(response)
            })
    }


    function modal_preguntas_respuest() {
        //const nombre_campana = document.querySelector('input[name="nombre_campana"]');
        comprobacion()
        const validacion = JSON.parse(localStorage.getItem('formData'));
        // console.log(validacion.barrios)


        console.log('bd_externa', bd_externar)
        if (bd_externar === 0) {
            let barrios = JSON.parse(validacion.barrios);
            let ciudad = JSON.parse(validacion.ciudades);
            let pais = JSON.parse(validacion.paises);
            let cantidad = JSON.parse(validacion.cantidades);
            for (let i = 0; i < barrios.length; i++) {
                if (barrios[i].id === null || barrios[i].id === "") {
                    alert("el barrio de la columna" + (i + 1) + " está vacío o es nulo.");
                    return;
                }

                if (pais[i].id === null || pais[i].id === "") {
                    alert("el pais de la columna" + (i + 1) + " está vacío o es nulo.");
                    return;
                }

                if (barrios[i].id === null || barrios[i].id === "") {
                    alert("el barrio de la columna" + (i + 1) + " está vacío o es nulo.");
                    return;
                }

                if (cantidad[i].id === null || cantidad[i].id === "") {
                    alert("el cantidad de la columna" + (i + 1) + " está vacío o es nulo.");
                    return;
                }
            }

            if (validacion.nombre_campana.length < 4) {
                alert('El nombre de la campana debe tener al menos 4 letras')
            }
            if (validacion.frecuencia.length < 1) {
                alert('debe seleccionar con que frecuencia desea enviar la campana')
            }
            if (
                validacion.nombre_campana.length >= 4 && validacion.frecuencia.length >= 1
            ) {
                modal_preguntas_y_respuesta.style.display = 'flex'
            }
        } else {
            modal_preguntas_y_respuesta.style.display = 'flex'
        }





    }

    function loadFormDataFromLocalStorage() {
        const storedFormData = JSON.parse(localStorage.getItem('formData'));
        if (storedFormData) {
            // Rellenar los campos individuales

            document.querySelector('input[name="nombre_campana"]').value = storedFormData.nombre_campana || '';
            document.querySelector('input[name="frecuencia"]').value = storedFormData.frecuencia || '';
            document.querySelector('select[name="temporalidad"]').value = storedFormData.temporalidad || '';
            document.querySelector('select[name="plan"]').value = storedFormData.plan || '';
            document.querySelector('input[name="como_me_llamo"]').value = storedFormData.como_me_llamo || '';
            document.querySelector('select[name="objetivo_lubot"]').value = storedFormData.objetivo_lubot || '';
            document.querySelector('textarea[name="spbre_la_empresa"]').value = storedFormData.spbre_la_empresa || '';

            if (bd_externar === 0) {
                document.querySelector('select[name="segmento"]').value = storedFormData.segmento || '';
                // Rellenar los arrays de objetos
                const paisesArray = JSON.parse(storedFormData.paises) || [];
                paisesArray.forEach((pais, index) => {
                    if (index > 0) addRow(); // Añadir nuevas filas si hay más de un país
                    document.querySelectorAll('select[name="pais[]"]')[index].value = pais.id;
                });

                const ciudadesArray = JSON.parse(storedFormData.ciudades) || [];
                ciudadesArray.forEach((ciudad, index) => {
                    document.querySelectorAll('select[name="ciudad[]"]')[index].value = ciudad.id;
                });

                const barriosArray = JSON.parse(storedFormData.barrios) || [];
                barriosArray.forEach((barrio, index) => {
                    document.querySelectorAll('select[name="barrio[]"]')[index].value = barrio.id;
                });

                const cantidadesArray = JSON.parse(storedFormData.cantidades) || [];
                cantidadesArray.forEach((cantidad, index) => {
                    document.querySelectorAll('input[name="cantidad[]"]')[index].value = cantidad.cantidad;
                });
            }


            const preguntasRespuestasArray = JSON.parse(storedFormData.preguntas_respuestas) || [];
            preguntasRespuestasArray.forEach((item, index) => {
                if (index > 0) addForm(document.querySelector('#form-container .btn-success:last-child'));
                document.querySelectorAll('input[name="pregunta[]"]')[index].value = item.pregunta;
                document.querySelectorAll('input[name="respuesta[]"]')[index].value = item.respuesta;
            });
        }
    }


    loadFormDataFromLocalStorage()
</script>
