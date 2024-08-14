<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Controllers\AccountBaseController;
use Modules\Lubot\Http\Controllers\HelperController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http;


class LubotController extends AccountBaseController
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

    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
         $this->activeMenu = 'lubot';
        return view('lubot::index' , $this->data);
    }

    public function registrar_empresa(){
        DB::table('config_lubots')->insert([
            'estado' => 1,
            'nombre_usuario' => $this->data['company']['name'],
            'numero' => null,
            'id_companies' => $this->data['company']['id'],
            'code_ws' => null,
            'code_rc' => null,
            'id_codigo' => null,
            'estado_ws' => 0,
            'estado_rc' => 0,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function Activacion()
    {
        
        $this->data['activar_ws_url'] = HelperController::endpoiny('ejecutable_inicio_sesion');
        $this->data['logo'] = HelperController::public('logo');
        $this->data['id_companie'] = $this->data['company']['id'];
        $activacion = DB::table('config_lubots')->where('id_companies' ,$this->data['company']['id'] )->exists();
        if(!$activacion)
        {
           return  $this->registrar_empresa();
            $activacion = true;
        }
        $this->data['codigos'] = DB::table('codigos')->get();
        $this->data['activacion'] = $activacion;
        $this->data['pageTitle'] = "Activacion";
        $this->data['data_companias'] =  $activacion === true ? DB::table('config_lubots')->where('id_companies' ,$this->data['company']['id'] )->first() : '';
        $this->data['numero']= $this->data['data_companias']->numero ?? "";
        return view('lubot::activacion.index' , $this->data);
    }

    public function datas_compania()
    {
          $data = DB::table('config_lubots')->where('id_companies' ,$this->data['company']['id'] )->first();
       return response()->json($data);
    }

    public function activacion_post(Request $request)
    {
      
        if(Schema::hasTable('config_lubots'))
        {
           $existe = DB::table('config_lubots')->where('id_companies' ,$this->data['company']['id'] )->exists();
           if($existe)
           {
              DB::table('config_lubots')->where('id_companies', $this->data['company']['id'] )->update(['numero' => $request->numero , 'id_codigo' => $request->codigo]);
              return back();
           }
            $activar =  DB::table('config_lubots')->insert(
                [
                    'estado' => 1,
                    'id_companies' => $this->data['company']['id'],
                    'nombre_usuario' => 's',
                    'numero' => trim($request->numero),
                    'id_codigo' => $request->codigo
                ]
            );

            return back() ;
        }
       
    }

    public function correr_bot($companie_id){
        $url_webhook = HelperController::url('WEB_HOOK_RUL') ;
        $response = Http::withHeaders(['Accept' => 'application/json'])->get("{$url_webhook}/activar_ws/{$companie_id}");
        return json_encode(['ok' => 'ok' ,  $response]);
    }

    public function cambiar_estado($user_id , $estado){
        if($estado === 0 )  DB::table('config_lubots')->where('id_companies' , $user_id )->update(['estado_ws' => 0 ]);
        if($estado === 1 )  DB::table('config_lubots')->where('id_companies' , $user_id )->update(['estado_ws' => 1 ]);
        if($estado === 2 )  DB::table('config_lubots')->where('id_companies' , $user_id )->update(['estado_ws' => null ]);
        if($estado > 2) return response()->json(['success' => 'este estado no existe']);
        return response()->json([
            'success' => 'evento terminado'
        ]);
    }
    
}
