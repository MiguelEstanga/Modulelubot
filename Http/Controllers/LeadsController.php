<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Lubot\Http\Controllers\HelperController;
class LeadsController extends Controller
{
    public function leads()
    {

        // Realizar la solicitud HTTP para obtener los clientes
        $response = Http::withHeaders(['Accept' => 'application/json'])
            ->get('https://lubot.healtheworld.com.co/api/autowebs_clientes');
        $clientes = json_decode($response->body(), true);

        // Obtener todos los leads de la base de datos
        $leads = DB::table('leads')->pluck('mobile')->toArray();

        $test = [];

        foreach ($clientes as $cliente) {
            if ($cliente['ws'] === 1 && $cliente['bot_finalizado'] === 1 && $cliente['valid'] === 1) {
                $telefono = $cliente['telefono'];

                // Realizar una solicitud HTTP para obtener el cliente aprobado
                $response_cliente_aprovado = Http::withHeaders(['Accept' => 'application/json'])
                    ->get("https://lubot.healtheworld.com.co/api/autowebs_negocios/{$telefono}");
                $parse_response_cliente_aprovado = json_decode($response_cliente_aprovado->body(), true);

                // Verificar si el teléfono no está en los leads
                if (!in_array($parse_response_cliente_aprovado['empresa']['telefono'], $leads)) {
                    $test[] = $parse_response_cliente_aprovado;
                    $aqui = DB::table('leads')->insert([
                        'company_id' => $this->data['company']['id'],
                        'client_id' => null,
                        'source_id' => 13,
                        'status_id' => 5,
                        'column_priority' => 0,
                        'agent_id' => 1,
                        'company_name' =>  $this->data['company']['company_name'] ?? null,
                        'website' => $this->data['company']['website'] ?? null,
                        'address' => $parse_response_cliente_aprovado['pais'] . "," . $parse_response_cliente_aprovado['ciudad'] . "," . $parse_response_cliente_aprovado['barrio'],
                        "salutation" => 'mr',
                        "client_name" => $parse_response_cliente_aprovado['empresa']['nombre'],
                        "client_email" => "lubot" . count($leads) . "@gmail.com",
                        "mobile" => $parse_response_cliente_aprovado['empresa']['telefono'],
                        "cell" => null,
                        "office" => null,
                        "city" =>  $parse_response_cliente_aprovado['ciudad'],
                        "state" => $parse_response_cliente_aprovado['barrio'],
                        "postal_code" => null,
                        "note" => "lubot",
                        "currency_id" => 7,
                        "category_id" => 1,
                        "last_updated_by" => 1,
                        "hash" => Str::random(40),
                        "created_at" => now(),
                        "updated_at" => now()
                    ]);
                }
            }
        }
    }
}
