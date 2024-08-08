<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Controllers\AccountBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Lubot\DataTables\CampanaTable;
use Modules\Lubot\DataTables\SegmentosTable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use  Modules\Lubot\Http\Controllers\HelperController;
class CampanasController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.balance_admin';
        $this->activeSettingMenu = 'front_theme_settings';
        $this->middleware(
            function ($request, $next) {
              //  abort_403(!in_array('balance', $this->user->modules));
                return $next($request);
            }
        );
    }

    protected $ACTIVAR_BOT= "https://5281-186-114-249-60.ngrok-free.app/api/testBot";
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
     public $API_LUBOT_MASTER = 'https://lubot.healtheworld.com.co/api';
     
     protected $API_LUBOT_ENDPOINT = [
        'paises' => "paises",
        'segmentos' => 'tipos_negocios',
        'barrios' => 'barrios',
        'ciudades' => 'ciudades'
     ];
     public function Lubot()
    {
        if ( Schema::hasTable('lubot') ) {
       
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
                            'agent_id' => 1 ,
                            'company_name' =>  $this->data['company']['company_name'] ?? null,
                            'website' => $this->data['company']['website'] ?? null ,
                            'address' => $parse_response_cliente_aprovado['pais'].",".$parse_response_cliente_aprovado['ciudad'].",".$parse_response_cliente_aprovado['barrio'],
                            "salutation" => 'mr',
                            "client_name" => $parse_response_cliente_aprovado['empresa']['nombre'],
                            "client_email" => "lubot".count($leads)."@gmail.com",
                            "mobile" => $parse_response_cliente_aprovado['empresa']['telefono'],
                            "cell" => null ,
                            "office" => null,
                            "city" =>  $parse_response_cliente_aprovado['ciudad'],
                            "state" => $parse_response_cliente_aprovado['barrio'],
                            "postal_code" => null,
                            "note"=> "lubot",
                            "currency_id" => 7 ,
                            "category_id" => 1,
                            "last_updated_by"=> 1,
                            "hash" =>Str::random(40),
                            "created_at" => now(),
                            "updated_at" => now()
                        ]);
                    }
                }

                
            }
            //pisa papeles 
        }
    }

    //returno de paises lubot_master
    public function paises(){
       $response = Http::withHeaders(['Accept' => 'application/json'])->get(HelperController::endpoiny('paises'));
       $data = json_decode($response ,true );
       return $data;
    }

    public function segmentos(){
        $response = Http::withHeaders(['Accept' => 'application/json'])->get( HelperController::endpoiny('segmentos'));
        $data = json_decode($response ,true );
        return $data;
     }

     public function barrios(){
        $response = Http::withHeaders(['Accept' => 'application/json'])->get( HelperController::endpoiny('barrios'));
        $data = json_decode($response ,true );
        return $data;
     }

     public function ciudades(){
        $response = Http::withHeaders(['Accept' => 'application/json'])->get(HelperController::endpoiny('ciudades'));
        $data = json_decode($response ,true );
        return $data;
     }

    public function index()
    {
        $this->data['segmentos'] = $this->segmentos() ?? [];
        $this->data['objetivos'] = DB::table('objetivos_lubot')->get() ?? [];
        $this->data['ciudades'] = $this->ciudades() ?? [];
       
        $this->data['barrios'] = $this->barrios() ?? [];
        $this->data['paises'] = $this->paises() ?? [];
        $this->activeMenu = 'lubot';
        return view('lubot::campanas.index' , $this->data);
    }

    public function campanas_stores(Request $request)
    {
        if(!Schema::hasTable('campanas') ) return back();
        if(!Schema::hasTable('segmentos')) return back();
        if(!Schema::hasTable('prompts')  ) return back();
       // return HelperController::endpoiny('activar_ejecutable_ws');
        $data_promps = [];
        if($request->input('mode') === 1){
            for($i = 0 ; $i< count($request->input('pregunta')) ; $i++)
            {
                $data_promps[] = [
                    'pregunta' => $request->input('pregunta')[$i],
                    'respuesta' => $request->input('respuesta')[$i],
                ];
            }
          
        }
        
        $campana_id = DB::table('campanas')->insertGetId(  
            [
                'id_companies' => $this->data['company']['id'],
                'nombre' => $request->nombre_campanas,
                'responder_con_ia' => 1,
                'campanas_activa' => 1,
                'objetivo_de_lubot' => $request->objetivo
            ]
        );
        $check = DB::table("campanas")->where('id' , $campana_id)->exists();
        if(!$check ) return back();

        DB::table('prompts')
        ->insert(
            [
                'prompt' => (int)$request->mode === 1 ?  json_encode($data_promps) : "Saludo Generico",
                'id_campanas' =>  $campana_id
            ]
        );
            for($i = 0 ; $i <= count($request->pais) -1 ; $i++)
            {
                DB::table('segmentos')->insert(
                    [
                        'id_campanas' =>  $campana_id ,
                        'segmento' => $request->segmento[$i],
                        'ciudad'   => $request->ciudad[$i],
                        'pais'     => $request->pais[$i],
                        'barrio'   => $request->barrio[$i] ,
                        'cantidad' => $request->cantidad[$i]
                    ]
                );
            }
        
            
          
        //$this->Lubot();
        $response = Http::withHeaders(['Accept' => 'application/json'])
        ->get(HelperController::endpoiny('activar_ejecutable_ws')."/{$this->data['company']['id']}/{$campana_id}/{$this->data['company']['id']}");
      //  return json_decode($response ,true );
        return redirect()->route('ver_campanas.todas');
       
      
        
    }
  
    public function ver_campanas(CampanaTable $dataTable)
    {
       
        $this->activeMenu = 'Campañas';
         $campanas =  DB::table('campanas')->where('id_companies' ,  $this->data['company']['id'])->get();
        //return $prompt = DB::table('prompts')->where('id_campanas', 6)->first()->prompt;
         $this->data['campanas'] = $campanas;
        return $dataTable->render('lubot::campanas.campanas' , $this->data);
    }

    public function eliminar($id)
    {
         $campanas =  DB::table('campanas')->where('id' ,  $id)->first();
          //$prompt =  DB::table('prompts')->where('id_campanas' ,   $campanas->id )->delete();
       

          $segmentos = DB::table('segmentos')->where('id_campanas' ,  $id)->get();
         foreach($segmentos as $segmento)
         {
             DB::table('segmentos')->where('id' ,  $segmento->id)->delete();
         }
         DB::table('campanas')->where('id' ,  $id)->delete();
         //$campanas->delete();
         return back();
    }

   
        public function cambiar($id)
        {
            // Obtén el registro de la campaña
            $campana = DB::table('campanas')->where('id', $id)->first();
    
            if (!$campana) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Campaña no encontrada'
                ]);
            }
    
            // Cambia el estado de la campaña
            $nuevoEstado = $campana->campanas_activa === 0 ? 1 : 0;
    
            // Actualiza el registro en la base de datos
            DB::table('campanas')->where('id', $id)->update(['campanas_activa' => $nuevoEstado]);
    
            // Obtén el registro actualizado
            $campanaActualizada = DB::table('campanas')->where('id', $id)->first();
    
            return response()->json([
                'status' => 200,
                'campana' => $campanaActualizada
            ]);
        }
        
        public function campana_segmentos(SegmentosTable $dataTable ,  $id)
        {
             $segmentos = DB::table('segmentos')->where('id_campanas' , $id)->get();
             $campana = DB::table('campanas')->where('id', $id)->first();
             $this->data['segmentos'] = $segmentos;
             $this->data['campana'] = $campana;
             $dataTable->withId($id);
             return $dataTable->render('lubot::campanas.segmentos' ,  $this->data);
        }
        
        public function eliminar_segmentos($id)
        {
            DB::table('segmentos')->where('id' ,  $id)->delete();
            return back();
        }
}
