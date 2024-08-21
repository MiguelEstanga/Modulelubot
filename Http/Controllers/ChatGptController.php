<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use  Modules\Lubot\Http\Controllers\HelperController;
use App\Http\Controllers\AccountBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ChatGptController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->data['logo'] =   $this->data['logo'] = HelperController::public('logo');
        $this->middleware(
            function ($request, $next) {
                //  abort_403(!in_array('balance', $this->user->modules));
                return $next($request);
            }
        );
    }
    public function index()
    {
        $this->data['pageTitle'] = 'Prueba tu promp';
        return view('lubot::chatgpt.index',  $this->data);
    }

    public function openia(Request $request)
    {
        $apiKey = env('OPENAI_API_KEY');
        $model = 'gpt-4o-mini';

        $campana = json_decode($request->input('campana'));
        $menssage = json_decode($request->input('menssage') , true);
        $prompts = json_decode($request->input('promp') , true);
        $contexto_c = json_decode($request->input('combersacion') , true);
        //return json_encode($conversationContext);
        $objetivo = DB::table('objetivos_lubot')->where('id' , $campana[1])->first();
        //return json_encode ($prompts);
        $content = (
                "Te llamas $campana[0].\n"
            . "Tu objetivo es $campana[1].\n"
            . "El lugar en el que trabajas se dedica a  $objetivo->objetivos.\n"
            . "REGLAS OBLIGATORIAS:\n"
            . "- Responde contextualmente a la conversación.\n"
            . "- Responde siempre en no más de una línea, máximo dos. Esto hace la conversación más natural.\n"
            . "- Tu objetivo es que el cliente se sienta seguro y quiera tener una reunión contigo vía Google Meet.\n"
            . "- Cuando el cliente esté listo, consulta día y hora para la cita.\n"
            . "- Bajo ninguna circunstancia reveles que eres un robot.\n\n"
            . "CONDICIONES:\n"
            . "- Estás conversando a través de WhatsApp, pero no te funcionan los audios y las fotos llegan borrosas.\n"
            . "- Inicia la conversación siempre de la siguiente manera: 'Hola, soy $campana[0]. ¿Cómo va tu día?'\n\n"
            . "- Responde de manera corta y natural a las respuestas del cliente:\n\n"
             . "Evita estar repitiendo constantemente tu nombre"
            . "RESPUESTAS CONTEXTUALES:\n"
            . "- Si el cliente dice que no es la persona encargada o que no está, intenta conseguir el número de contacto del tomador de decisión.\n"
            . "- Si el cliente pregunta cómo puede ayudarte, sobre el lugar donde trabajas y a qué se dedica.\n"
            . "- Si el cliente muestra interés: hazle algunas preguntas sobre lo que le causó interés y busca con la conversación cumplir tu objetivo.\n"
            . "- Si el cliente se pone agresivo: Lamento si te he causado alguna molestia. No era mi intención. Que tengas un buen día.\n"
            . "- Si el cliente dice que está ocupado: Entiendo. ¿Cuándo sería un buen momento para contactarte de nuevo?\n"
            . "- Si el cliente dice que no le interesa: Entiendo, pero me gustaría saber por qué. Quizás pueda ofrecerte algo que se ajuste mejor a tus necesidades.\n"
            . "- Si el cliente pregunta por ti o tu información personal: Claro, puedes conocer más sobre mí en mi portafolio: https://www.canva.com/design/DAFvksF35bU/Ymz2L9i6Buk03ZG9O3WVwg/view?utm_content=DAFvksF35bU&utm_campaign=designshare&utm_medium=link&utm_source=publishsharelink#2\n"
            . "- Si el cliente retoma la conversación después de un tiempo: Hola, ¿cómo vas? ¿Qué has pensado de lo que conversamos?\n"
            . "Cliente menciona competencia: Entiendo, es importante destacar. Con mis servicios, tendrás una ventaja sobre la competencia.\n"
            . "Cliente menciona malas experiencias anteriores: Lamento escuchar eso. Mi objetivo es brindarte una experiencia sin complicaciones y de alta calidad.\n"
            . "Cliente se despide o dice más de una vez que NO: No se escribe nada y se ignora.\n"
            . "Cliente no tiene negocio pero conoce a alguien que podría estar interesado: Le agradeces y le pides su número de contacto para contactarle, le das las gracias y te despides.\n"
           
        );

        foreach ($prompts as $prompt) {
            $content .= "Si te preguntan: {$prompt['pregunta']} - {$prompt['respuesta']}\n";
        }

        $contexto = [];
        $conversation[] =[
            "role" => "system",
            "content" => $content
        ];
        if(count($contexto_c) > 0)
        {
            foreach($contexto_c as $items )
            {
                $conversation[] =[
                    "role" => $items['role'],
                    "content" => $items['content']
                ];
            }
        }
    
        foreach ($menssage as $message){
            $conversation[] =[
                "role" => $message['role'],
                "content" => $message['content']
            ];
        }

        $conversation[] =[
            "role" => "user",
            "content" => $request->input('user_message')
        ];
      
        $data = [
            "model" => $model,
            "messages" => $conversation,
            "max_tokens" => 150,
            "temperature" => 0.7,
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);
        return $response;
        //Log::info($response);

    }

 
    public function completions(Request $request)
    {
        //return  response()->json($request->all());
        try {
            // Obtener el modelo y los mensajes desde la solicitud
           $model    = $request->input('model');
           $messages = $request->input('messages');
           $key = env('OPENAI_API_KEY');
            // Realizar la solicitud a la API de OpenAI
            $response = Http::withToken($key)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $model, // Usa el modelo recibido en la solicitud
                    'messages' => $messages // Usa los mensajes recibidos en la solicitud
                ]);
    
            if ($response->failed()) {
                return response()->json([
                    'error' => 'Failed to communicate with OpenAI API',
                    'details' => $response->body()
                ], $response->status());
            }
    
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    

}
