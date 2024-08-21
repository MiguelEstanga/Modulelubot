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
    </div>


    <script>
        const _chatBox = document.getElementById('chat-box');
        const _chatForm = document.getElementById('chat-form');
        const _chatInput = document.getElementById('chat-input');



        _chatForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const userMessage = _chatInput.value.trim();
            if (!userMessage) return;

            // Añadir mensaje del usuario al chat
            addMessageToChat(userMessage, 'user');

            // Limpiar el input
            _chatInput.value = '';

            // Obtener la conversación previa y otros datos almacenados en localStorage
            let storedData = JSON.parse(localStorage.getItem('formData')) || {};
            let conversationContext = JSON.parse(localStorage.getItem('conversationContext')) || [];

            // Cargar ejemplos de entrenamiento desde localStorage
            const promp = JSON.parse(storedData.preguntas_respuestas || '[]');
            let campana = storedData.campana || [];

            // Concatenar el nuevo mensaje del usuario al contexto de la conversación
            conversationContext.push({
                role: "user",
                content: userMessage
            });

            // Concatenar el mensaje del usuario al array `trainingExamples`
            promp.forEach(element => {
                conversationContext.push({
                    role: "user",
                    content: element.pregunta
                });
                conversationContext.push({
                    role: "system",
                    content: element.respuesta
                });
            });

            campana.push(storedData.como_me_llamo);
            campana.push(storedData.objetivo_lubot);
            campana.push(storedData.spbre_la_empresa);

            // Preparar el cuerpo de la solicitud
            const body = JSON.stringify({
                menssage: JSON.stringify(conversationContext),
                campana: JSON.stringify(campana),
                promp: JSON.stringify(promp),
                user_message: userMessage
            });

            console.log(conversationContext);
            console.log(promp);
            console.log(userMessage);
            console.log(campana);

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
                console.log(data);

                // Añadir respuesta del bot al chat y al contexto
                if (data.choices && data.choices.length > 0) {
                    const botMessage = data.choices[0].message.content;
                    addMessageToChat(botMessage, 'bot');

                    // Concatenar la respuesta del bot al contexto de la conversación
                    conversationContext.push({
                        role: "system",
                        content: botMessage
                    });

                    // Actualizar `formData` en localStorage
                    storedData.preguntas_respuestas = JSON.stringify(promp);
                    storedData.campana = campana;
                    storedData.conversationContext = conversationContext;

                    localStorage.setItem('formData', JSON.stringify(storedData));
                } else {
                    addMessageToChat('No se recibió respuesta del bot.', 'error');
                }
            } catch (error) {
                // Mostrar mensaje de error en el chat
                addMessageToChat(`Error: ${error.message}`, 'error');
            }
        });

        // Al cargar la página, restaurar el contexto de la conversación
        document.addEventListener('DOMContentLoaded', () => {
            const storedData = JSON.parse(localStorage.getItem('formData')) || {};
            const conversationContext = storedData.conversationContext || [];

            // Restaura la conversación previa en el chat (si existe)
            conversationContext.forEach(message => {
                addMessageToChat(message.content, message.role === 'user' ? 'user' : 'bot');
            });
        });


        function addMessageToChat(message, sender) {
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', sender === 'user' ? 'user' : sender === 'bot' ? 'bot' : 'error');
            messageElement.textContent = message;
            _chatBox.appendChild(messageElement);

            // Desplazar el chat hacia abajo
            _chatBox.scrollTop = _chatBox.scrollHeight;
        }
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
            height: 835px;
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
