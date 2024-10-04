<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Lubot\Http\Controllers\HelperController;
use App\Http\Controllers\AccountBaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Log;
class LeadsController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->activeSettingMenu = 'lubot_settings';
        $this->middleware(
            function ($request, $next) {
                //  abort_403(!in_array('balance', $this->user->modules));
                return $next($request);
            }
        );
    }
    public static function  leads($companyId)
    {
        $metadata = array();
        // Realizar la solicitud HTTP para obtener los clientes
         $clientes = HelperController::get_leads($companyId);  
        // Obtener todos los leads de la base de datos
          $leads = DB::table('leads')->pluck('mobile')->toArray();

        //return $clientes;
        //recorremos todos los clientes
        foreach ($clientes['data'] as $cliente) {
          
                $telefono = $cliente['tipo_negocio']['telefono'];

                // Verificar si el teléfono no está en los leads
                if (!in_array($telefono, $leads)) {
                    //$test[] = $parse_response_cliente_aprovado;
                    $metadata =array([
                        'company_id' => $companyId,
                        'client_id' => null,
                        'source_id' => 13,
                        'status_id' => 5,
                        'column_priority' => 0,
                        'agent_id' => 1,
                        'company_name' =>   $cliente['tipo_negocio']['nombre'] ?? null,
                        'website' => $cliente['tipo_negocio']['url_web'] ?? null,
                        'address' => $cliente['tipo_negocio']['pais_id']  . "," . $cliente['tipo_negocio']['ciudad_id'] . "," . $cliente['tipo_negocio']['barrio_id'] ,
                        "salutation" => 'mr',
                        "client_name" => $cliente['tipo_negocio']['nombre'],
                        "client_email" => "lubot" . count($leads) . "@gmail.com",
                        "mobile" =>$cliente['tipo_negocio']['telefono'],
                        "cell" => null,
                        "office" => null,
                        "city" =>  $cliente['tipo_negocio']['ciudad_id'],
                        "state" => $cliente['tipo_negocio']['direccion'],
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
        
        if( count($metadata) > 0 )
        {
            try{
                DB::table('leads')->insert($metadata);
                
                //$this->notificar_email("se a insertado nuevo leads ");
                return response()->json([
                    'status' => 200,
                    'mensage' => 'datos insertados correctamente'
                ]);
            }catch(Exception $e){
                Log::info('ha ocurrido un error en leadsController este es el log de la linea 83');
                self::notificar_email("a ocurrido un nuevo error al usuario con id  ");
                Log::info($e);
                return response()->json([
                    'status' => 500,
                    'mensage'=> 'error ' .$e
                ]);
            }
        }
      //  self::notificar_email("se entro al controlador de la empresa con el id  pero no se encontro ningun lead nuevo  ");
        return response()->json([
            'status' => 200,
            'mensage' => 'no se ha encontrado novedades'
        ]);

    }

    public function notificar_email($msm)
    {
        Mail::raw($msm, function($message) {
            $message->to(['miguelestanga12@gmail.com'])
                    ->subject('Asunto del correo');
        });
    }
}
