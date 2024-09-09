<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AccountBaseController;

class HelperController extends AccountBaseController
{
  public function __construct()
  {
    parent::__construct();
    $this->activeSettingMenu = 'lubot_settings';

    $this->data['logo'] =   $this->data['logo'] = HelperController::public('logo');
    $this->middleware(
      function ($request, $next) {
        //  abort_403(!in_array('balance', $this->user->modules));
        return $next($request);
      }
    );
  }



  public static function db_name($id)
  {
    $bd = DB::table('user_db')->where('id_companies', $id)->first();
    return $bd->nombre;
  }

  public static function url($key)
  {
    $config = DB::table('lubot_settings')->first() ?? [];
    $data = [
      'lubot_master_url' => $config->LUBOT_MASTER ?? "https://lubot.healtheworld.com.co/", //'https://lubot.healtheworld.com.co/',
      'WEB_HOOK_RUL' => $config->NGROK_LUBOT_WEBHOOK ?? "https://2c09-186-112-18-249.ngrok-free.app/api", //"https://2c09-186-112-18-249.ngrok-free.app/api", 
      'lubot_master' => $config->LUBOT_MASTER_API ?? "https://lubot.healtheworld.com.co/api", // "https://lubot.healtheworld.com.co/api" 
      'BEARER_TOKEN' =>  $config->BEARER_LUBOT_MASTER ?? "8lbA52huHchhbswplKpH0OcUsr+QIgFZRkfdNsYUGhk="
    ];
    return  $data[$key];
  }
  // filtro de paises 
  public static function con_pais($nombre , $name = false )
  {
    $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::url('lubot_master_url') . "pais/{$nombre}");
    $data = json_decode($response, true);
    if($name) return $data['nombre'] ??  "todas";
    return $data['id'] ?? 0;
  }

  public static function con_ciudad($nombre , $name = false )
  {
    $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::url('lubot_master_url') . "ciudad/{$nombre}");
    $data = json_decode($response, true);
    if($name) return $data['nombre'] ?? "todas";
    return $data['id'] ?? 0;
  }

  public static function con_barrios($nombre ,$name = false )
  {
    $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::url('lubot_master_url') . "barrios/{$nombre}");
    $data = json_decode($response, true);
    if($name) return $data['nombre'] ??  "todas";
    return $data['id'] ?? 0;
  }

  public static function con_tipo_negocio($nombre , $name = false )
  {
    $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::url('lubot_master_url') . "tipo_negocio/{$nombre}");
    $data = json_decode($response, true);
    if($name) return $data['nombre'] ??  "todas";
    return $data['id'] ?? 0;
  }

  public static function public($key)
  {
    $data =  [
      'logo' =>  'https://res.cloudinary.com/deq9rulqu/image/upload/v1723675402/lubot_icon_ovm7y2.png', //asset('lubot_icon.png'),
      'requiest' =>  'https://res.cloudinary.com/deq9rulqu/image/upload/v1723675399/request_aohokz.png' //asset('request.png'),
    ];
    return $data[$key];
  }
  public static function endpoiny($key, $id = 0)
  {
    //$web_hook = self::url('lubot_master'); produccion
    $web_hook = self::url('WEB_HOOK_RUL'); // desarrollo
    $lubot_master = self::url('lubot_master');
    $data = [
      'ejecutable_inicio_sesion' => "{$web_hook}/activar_inicio_session",
      'activar_ejecutable_ws' => "{$web_hook}/activar_ejecutable_ws",
      'activar_ejecutable_ryc' => "{$web_hook}/activar_ejecutable_ryc",
      'paises'  => "{$lubot_master}/paises",
      'segmentos'  => "{$lubot_master}/tipos_negocios",
      'barrios'  => "{$lubot_master}/barrios",
      'ciudades'  => "{$lubot_master}/ciudades",
    ];
    return  $data[$key];
  }

  public static function calculateNextRun($frequencyNumber, $frequencyUnit)
  {
    date_default_timezone_set('America/Bogota');
    $nextRun = now();

    switch ($frequencyUnit) {
      case 'minutes':
        $nextRun->addMinutes($frequencyNumber);
        break;
      case 'hours':
        $nextRun->addHours($frequencyNumber);
        break;
      case 'days':
        $nextRun->addDays($frequencyNumber);
        break;
      case 'weeks':
        $nextRun->addWeeks($frequencyNumber);
        break;
    }

    return $nextRun;
  }

  //returno de paises lubot_master
  public function paises()
  {
    $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::endpoiny('paises'));
    $data = json_decode($response, true);
    return $data;
  }

  public function tipo_de_negocio()
  {
    $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::endpoiny('segmentos'));
    $data = json_decode($response, true);
    return $data;
  }

  public function barrios()
  {
    $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::endpoiny('barrios'));
    $data = json_decode($response, true);
    return $data;
  }

  public function ciudades()
  {
    $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::endpoiny('ciudades'));
    $data = json_decode($response, true);
    return $data;
  }
}
