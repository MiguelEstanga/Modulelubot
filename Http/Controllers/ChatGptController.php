<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use  Modules\Lubot\Http\Controllers\HelperController;
use App\Http\Controllers\AccountBaseController;
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

        // $messages = $request->input('messages');
        response()->json( $request->all() );
        // Hacer la solicitud a la API de OpenAI
        $key = env('OPENAI_API_KEY');
        $response = Http::withToken($key)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4', // Puedes ajustar el modelo según tus necesidades
                'messages' => ['user' => "hola"]
            ]);

        // Devolver la respuesta de OpenAI al frontend
        return response()->json($response->json());
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
