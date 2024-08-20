<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use  Modules\Lubot\Http\Controllers\HelperController;
use App\Http\Controllers\AccountBaseController;

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
        $curl = curl_init();
        $api_key = env('OPENAI_API_KEY');
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{
            "model": "gpt-4o",
            "messages": [{"role":"system","content":"You are a helpful assistant."},{"role":"user","content":"Who won the world series in 2020?"},{"role":"assistant","content":"The Los Angeles Dodgers won the World Series in 2020."},{"role":"user","content":"Where was it played?"}] 
        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                "Authorization: Bearer {$api_key}"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return  $response;
    }
}
