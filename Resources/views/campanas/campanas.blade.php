@extends('layouts.app')
@push('datatable-styles')
    @include('sections.datatable_css')
@endpush
@include('lubot::css.css')
@if (in_array('admin', user_roles()))
    @section('content')
        <div class="content-wrapper">
            <div class="d-flex flex-column w-tables rounded mt-3 bg-white" style="padding: 10px;">
                {{ $dataTable->table(['class' => 'table table-hover border-0 w-100']) }}
            </div>


        </div>

        <div class="_modal" style="display: none; " id="__modal_edit">
           
            <div class="card">
                <div class="cancelar " id="cancelar">
                    X
                </div>
                <div class="preguntas_respuesta__" style="margin-top:10px;">
                    <h2 class="h2">
                        Editar Propmps
                    </h2>
                    <div id="form-container">
                       
                        <div class="preguntas_respuesta">
                            <div class="">
                                <input type="text" class="custom_input margin-none" placeholder="Si el cliente dice:"
                                    name="pregunta[]">
                            </div>
                            <div class="">
                                <input type="text" class="custom_input margin-none"
                                    placeholder="Lubot debería responder:" name="respuesta[]">
                            </div>
                            <div class="container_agregar_borrar">
                                <button class="btn btn-success btn_mas_menos" type="button"
                                    onclick="addForm(this)">+</button>
                            </div>
                        </div>


                    </div>
                    <div class="container_actulizae">
                        <button id="capturar_formulario" class="btn btn-primary" type="button">Capturar formulario</button>
                    </div>

                </div>
            </div>
        </div>
    @endsection
@endif




@push('scripts')
    @include('sections.datatable_js')

    <script>
        const showTable = () => {
            window.LaravelDataTables["orders-table"].draw(false);
        }
        console.log(document.querySelectorAll('.activate_campaigns'))
        let id_campana = 0;

        $('#orders-table').on('change', '.order-status', function() {
            var id = $(this).data('order-id');
            var status = $(this).val();

            changeOrderStatus(id, status);
        });


        cancelar.addEventListener('click' , function (){
            __modal_edit.style.display = 'none'
        })
        function edit(id) {
            id_campana = id;
            let route = `{{ route('propmps', '#') }}`
            let url_propms = route.split('#')[0];

            document.getElementById('__modal_edit').style.display = 'grid'
            fetch(`${url_propms}${id}`)
                .then(response => response.json())
                .then(data => {
                    const promptData = JSON.parse(data.prompt);
                    const container = document.getElementById('form-container');

                    // Limpiar el contenedor antes de agregar nuevos elementos
                    container.innerHTML = '';

                    promptData.forEach((item, index) => {
                        const pregunta = item.pregunta;
                        const respuesta = item.respuesta;

                        // Crear el div principal para la pregunta y respuesta
                        const preguntaRespuestaDiv = document.createElement('div');
                        preguntaRespuestaDiv.className = 'preguntas_respuesta';

                        // Crear el input de pregunta
                        const preguntaDiv = document.createElement('div');
                        const preguntaInput = document.createElement('input');
                        preguntaInput.type = 'text';
                        preguntaInput.className = 'custom_input margin-none';
                        preguntaInput.placeholder = 'Si el cliente dice:';
                        preguntaInput.name = 'pregunta[]';
                        preguntaInput.value = pregunta;
                        preguntaDiv.appendChild(preguntaInput);

                        // Crear el input de respuesta
                        const respuestaDiv = document.createElement('div');
                        const respuestaInput = document.createElement('input');
                        respuestaInput.type = 'text';
                        respuestaInput.className = 'custom_input margin-none';
                        respuestaInput.placeholder = 'Lubot debería responder:';
                        respuestaInput.name = 'respuesta[]';
                        respuestaInput.value = respuesta;
                        respuestaDiv.appendChild(respuestaInput);

                        // Crear los botones para agregar o eliminar campos solo en el último item
                        const containerAgregarBorrar = document.createElement('div');
                        containerAgregarBorrar.className = 'container_agregar_borrar';

                        if (index === promptData.length - 1) {
                            const addButton = document.createElement('button');
                            addButton.className = 'btn btn-success btn_mas_menos';
                            addButton.type = 'button';
                            addButton.textContent = '+';
                            addButton.onclick = () => addForm(addButton);

                            const removeButton = document.createElement('button');
                            removeButton.className = 'btn btn-danger btn_mas_menos';
                            removeButton.type = 'button';
                            removeButton.textContent = '-';
                            removeButton.onclick = () => removeForm(removeButton);

                            containerAgregarBorrar.appendChild(addButton);
                            containerAgregarBorrar.appendChild(removeButton);
                        }

                        // Agregar los elementos al div principal
                        preguntaRespuestaDiv.appendChild(preguntaDiv);
                        preguntaRespuestaDiv.appendChild(respuestaDiv);
                        preguntaRespuestaDiv.appendChild(containerAgregarBorrar);

                        // Insertar el div principal en el contenedor
                        container.appendChild(preguntaRespuestaDiv);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        

        // Función para agregar una nueva fila
        function addForm(button) {
            const newForm = `
        <div class="preguntas_respuesta">
            <div class="">
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
        }

        // Función para eliminar una fila
        function removeForm(button) {
            const rowToRemove = button.closest('.preguntas_respuesta');
            rowToRemove.remove();

            // Asegurarse de que siempre haya un botón "+" en la última fila
            const formContainer = document.getElementById('form-container');
            const lastRow = formContainer.querySelector('.preguntas_respuesta:last-child .container_agregar_borrar');
            if (!lastRow.querySelector('button[onclick^="addForm"]')) {
                lastRow.insertAdjacentHTML('beforeend',
                    '<button class="btn btn-success btn_mas_menos" type="button" onclick="addForm(this)">+</button>'
                );
            }
        }

        // Función para capturar todos los datos del formulario
        function capturarFormulario() {
            const preguntas = document.querySelectorAll('input[name="pregunta[]"]');
            const respuestas = document.querySelectorAll('input[name="respuesta[]"]');
            let route = `{{ route('propmps_update', '#') }}`
            let url_propms = route.split('#')[0];
            const data = [];
            console.log(id_campana)
            preguntas.forEach((pregunta, index) => {
                data.push({
                    pregunta: pregunta.value,
                    respuesta: respuestas[index].value
                });
            });
            const formData = {
                prompts: data
            };
            fetch(`${url_propms}${id_campana}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // Token CSRF para seguridad
                    },
                    body: JSON.stringify(formData) // Convertir el objeto formData a JSON para enviarlo
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    if(data.status === 200 ) location.reload();
                    // Puedes agregar aquí alguna lógica para manejar la respuesta de Laravel

                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Hubo un error al enviar el formulario');
                });
            console.log(data); // Puedes enviar este JSON al servidor con fetch o AJAX
        }

        document.getElementById('capturar_formulario').addEventListener('click', capturarFormulario);
    </script>
@endpush
<style>
    .btn_mas_menos {
        width: 39px !important;
        height: 36px !important;
    }

    .container_agregar_borrar {

        min-width: 90px;

    }

    .preguntas_respuesta__ {
        overflow-y: scroll;
        height: 600px;
        margin-top: 10px;
        margin-bottom: 10px;
        scrollbar-width: thin;
        /* Ancho de la scrollbar (auto, thin, none) */
        scrollbar-color: #888 #f1f1f1;
        /* Color del thumb y del track */

    }

    /* Estilo general para la scrollbar dentro del div */
    .preguntas_respuesta__::-webkit-scrollbar {
        width: 10px;
        /* Ancho de la scrollbar */
    }

    /* Estilo de la parte interna de la scrollbar */
    .preguntas_respuesta__::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Color de fondo del track de la scrollbar */
        border-radius: 10px;
        /* Bordes redondeados */
    }

    /* Estilo del thumb (la parte que se desplaza) de la scrollbar */
    .preguntas_respuesta__::-webkit-scrollbar-thumb {
        background: #888;
        /* Color del thumb */
        border-radius: 10px;
        /* Bordes redondeados */
    }

    /* Estilo del thumb al pasar el mouse por encima */
    .preguntas_respuesta__::-webkit-scrollbar-thumb:hover {
        background: #555;
        /* Color del thumb al hacer hover */
    }







    .preguntas_respuesta {
        max-width: 750px;
        margin: auto;
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    .container_preguntas_respuesta {
        padding: 10px;
        max-width: 859px;
        height: 691px;
        background: #fff;
        border-radius: 10px;
        position: relative;
    }



    .promps_btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    ._modal {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        top: 0;
        right: 0;
        display: grid;
        place-content: center;
    }

    ._modal .card {
        border-radius: 10px;
        background-color: white;
        width: 900px;
        padding: 10px;
        height: 700px;
    }

    .container_actulizae {
        margin: auto;
        width: 720px;
    }
    .cancelar{
        position: absolute;
        background-color: #555;
        width: 40px;
        height: 40px;
        border-radius: 50px;
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        right: 0;
        top: 0;
        cursor: pointer;
    }
    .card{
        position: relative;
    }

    .h2{
        text-align: center;
        font-size: 20px;
        margin-bottom: 20px;
    }
</style>

<style>

</style>
