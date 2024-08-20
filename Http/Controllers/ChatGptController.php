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

    public function openia()
    {
        
        $api_key = env('OPENAI_API_KEY');
        

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4', // Puedes usar 'gpt-3.5-turbo' o el modelo que prefieras
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful assistant.'
                ],
                [
                    'role' => 'user',
                    'content' => 'hola' // Mensaje del usuario
                ]
            ],
            'max_tokens' => 150, // Ajusta según tus necesidades
            'temperature' => 0.7, // Ajusta la creatividad de la respuesta
        ]);

        $data = json_decode($response->getBody(), true);

        return response()->json($data);
    }
}
