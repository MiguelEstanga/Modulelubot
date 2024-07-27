<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Controllers\AccountBaseController;
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

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function Activacion()
    {
       //return   DB::table('custom_link_settings')->get();
        $activacion = DB::table('config_lubots')->where('id_companies' ,$this->data['company']['id'] )->exists();
        $this->data['activacion'] = $activacion;
        $this->data['pageTitle'] = "Activacion";
         $this->data['data_companias'] =  $activacion === true ? DB::table('config_lubots')->where('id_companies' ,$this->data['company']['id'] )->first() : '';
        $this->data['numero']= $this->data['data_companias']->numero ?? "";
        return view('lubot::activacion.index' , $this->data);
    }
    public function activacion_post(Request $request)
    {
       
        if(Schema::hasTable('config_lubots'))
        {
           $existe = DB::table('config_lubots')->where('id_companies' ,$this->data['company']['id'] )->exists();
           if($existe)
           {
              DB::table('config_lubots')->where('id_companies', $this->data['company']['id'] )->update(['numero' => $request->numero]);
              return back();
           }
            $activar =  DB::table('config_lubots')->insert(
                [
                    'estado' => 1,
                    'id_companies' => $this->data['company']['id'],
                    'nombre_usuario' => 's',
                    'numero' => $request->numero,
                ]
            );

            return back() ;
        }
       
    }
    public function probar(){
        $response = Http::withHeaders(['Accept' => 'application/json'])
        ->get('https://1b1f-186-114-249-60.ngrok-free.app/api/testBot');
        $clientes = $response->body();
        return json_encode(['ok' => 'ok']);
        return 'ejecutando bot';
    }

    
}
