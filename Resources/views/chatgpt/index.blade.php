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

            // Obtener el contexto previo almacenado en localStorage
            let conversationContext = JSON.parse(localStorage.getItem('conversationContext')) || [];
            let campana = JSON.parse(localStorage.getItem('campanaContext')) || [];
            let userMessages = JSON.parse(localStorage.getItem('userMessages')) || [];

            // Añadir el nuevo mensaje del usuario al contexto y al almacenamiento de mensajes del usuario
            conversationContext.push({
                role: "user",
                content: userMessage
            });

            userMessages.push(userMessage);

            // Preparar el cuerpo de la solicitud
            const body = JSON.stringify({
                menssage: JSON.stringify(conversationContext),
                campana: JSON.stringify(campana)
            });

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

                // Añadir respuesta del bot al chat y al contexto
                if (data.choices && data.choices.length > 0) {
                    const botMessage = data.choices[0].message.content;
                    addMessageToChat(botMessage, 'bot');

                    // Añadir el mensaje del bot al contexto
                    conversationContext.push({
                        role: "system",
                        content: botMessage
                    });

                    // Actualizar el contexto en localStorage
                    localStorage.setItem('conversationContext', JSON.stringify(conversationContext));
                } else {
                    addMessageToChat('No se recibió respuesta del bot.', 'error');
                }

                // Actualizar los mensajes del usuario en localStorage
                localStorage.setItem('userMessages', JSON.stringify(userMessages));

            } catch (error) {
                // Mostrar mensaje de error en el chat
                addMessageToChat(`Error: ${error.message}`, 'error');
            }
        });

        // Inicializar la campaña en localStorage si no existe
        if (!localStorage.getItem('campanaContext')) {
            const estorage = JSON.parse(localStorage.getItem('formData'));
            if (estorage) {
                const campana = [
                    estorage.como_me_llamo,
                    estorage.objetivo_lubot,
                    estorage.spbre_la_empresa
                ];
                localStorage.setItem('campanaContext', JSON.stringify(campana));
            }
        }



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
