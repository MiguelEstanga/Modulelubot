@extends('layouts.app')
@section('content')
    @include('lubot::css.css')
    <div class="content-wrapper opciones">
        <div class="chat-container">
            <div class="chat-header">
                <img src="{{ $logo }}" alt="Bot">
                <div>
                    <h1>Prueba tu Lubot</h1>
                    <p>Simula que eres un cliente y yo te responderé.</p>
                </div>
            </div>
            <div id="chat-box">
                <!-- Mensajes del chat irán aquí -->
            </div>
            <form id="chat-form">
                <input type="text" id="chat-input" placeholder="Escribe un mensaje...">
                <button type="submit">Enviar</button>
            </form>
        </div>
        <div>
            <button class="btn btn-danger" onclick="limpiar_cache()">
                Limipiar cache
            </button>
        </div>
    </div>


    <script>
        const _chatBox = document.getElementById('chat-box');
        const _chatForm = document.getElementById('chat-form');
        const _chatInput = document.getElementById('chat-input');

        function limpiar_cache() {
            // Supongamos que tienes un objeto almacenado con la clave "miObjeto"
            localStorage.removeItem('conversacion');
            init_chat()
            location.reload();
        }
        _chatForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const userMessage = _chatInput.value.trim();
            if (!userMessage) return;

            // Añadir mensaje del usuario al chat
            addMessageToChat(userMessage, 'user');

            // Limpiar el input
            _chatInput.value = '';

            // Cargar ejemplos de entrenamiento desde localStorage
            const estorage = JSON.parse(localStorage.getItem('formData'));
            const promp = JSON.parse(estorage.preguntas_respuestas);
            let conversacion = JSON.parse(localStorage.getItem('conversacion')) || []
            let campana = [];
            let trainingExamples = [];

            promp.forEach(element => {
                trainingExamples.push({
                    role: "user",
                    content: element.pregunta
                });
                trainingExamples.push({
                    role: "system",
                    content: element.respuesta
                });
            });
            campana.push(estorage.como_me_llamo)
            campana.push(estorage.objetivo_lubot)
            campana.push(estorage.spbre_la_empresa)
            // Añadir el mensaje del usuario al final del array


            trainingExamples.push({
                role: "user",
                content: userMessage
            });

            // Preparar el cuerpo de la solicitud
            const body = JSON.stringify({
                menssage: JSON.stringify(trainingExamples),
                campana: JSON.stringify(campana),
                promp: JSON.stringify(promp),
                user_message: userMessage,
                conversacion: JSON.stringify(conversacion)
            });

            conversacion.push({
                role: "user",
                content: userMessage
            })
            //console.log(trainingExamples)
            //console.log(promp)
            // console.log(userMessage)
            //console.log(campana)
            console.log('conversacion')
            console.log(conversacion)
            localStorage.setItem('conversacion', JSON.stringify(conversacion));

            try {
                const response = await fetch(`{{ route('chatGpt.openia') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: body
                });

                const data = await response.json();
                console.log(data)
                console.log(JSON.parse(data.propmp))
                console.log(data.bot)
                // Añadir respuesta del bot al chat
                
                if (data.bot.choices && data.bot.choices.length > 0) {
                    addMessageToChat(data.bot.choices[0].message.content, 'bot');
                    conversacion.push({
                        role: "system",
                        content: data.bot.choices[0].message.content
                    });
                    localStorage.setItem('conversacion', JSON.stringify(conversacion));
                } else {
                    addMessageToChat('No se recibió respuesta del bot.', 'error');
                    // localStorage.setItem('conversacion', JSON.stringify(conversacion));
                }
            } catch (error) {
                // Mostrar mensaje de error en el chat
                addMessageToChat(`Error: ${error.message}`, 'error');
            }
        });

        function init_chat()
        {
            let conversacion = JSON.parse(localStorage.getItem('conversacion')) || []
            conversacion.forEach(items => {
                addMessageToChat(items.content, items.role);
                //console.log()
            })
        }
        function addMessageToChat(message, sender) {
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', sender === 'user' ? 'user' : sender === 'bot' ? 'bot' : 'error');
            messageElement.textContent = message;
            _chatBox.appendChild(messageElement);

            // Desplazar el chat hacia abajo
            _chatBox.scrollTop = _chatBox.scrollHeight;
        }

        init_chat()
    </script>
    <style>
        .container_chat {
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            max-width: 738px;
            margin: 0;
            font-family: Arial, sans-serif;
        }


        .chat-container {
            width: 100%;
            max-width: 758px;

            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .chat-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .chat-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat-header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .chat-header p {
            margin: 0;
            color: #6b7280;
        }

        #chat-box {
            background-color: #1f2937;
            color: white;
            border-radius: 8px;
            padding: 10px;
            max-width: 758px;
            height: 600px;
            overflow-y: auto;
        }

        .message {
            padding: 10px;
            border-radius: 8px;
            margin: 10px 0;
            max-width: 70%;
        }

        .message.user {
            background-color: #4b5563;
            margin-left: auto;
            text-align: right;
        }

        .message.bot {
            background-color: #10b981;
            margin-right: auto;
        }

        .message.error {
            background-color: #ef4444;
            margin-right: auto;
            color: #fff;
        }

        #chat-form {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        #chat-input {
            flex-grow: 1;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 14px;
        }

        #chat-input:focus {
            outline: none;
            border-color: #10b981;
        }

        #chat-form button {
            background-color: #10b981;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            margin-left: 10px;
            cursor: pointer;
        }

        #chat-form button:hover {
            background-color: #059669;
        }
    </style>
@endsection
