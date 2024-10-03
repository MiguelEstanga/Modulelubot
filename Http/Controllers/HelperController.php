<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AccountBaseController;
use Exception;

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

  public static function get_token()
  {
    return "8lbA52huHchhbswplKpH0OcUsr+QIgFZRkfdNsYUGhk=";
  }

  public static function  get_headers()
  {
    return   [
      'Accept' => 'application/json',
      'Authorization' => 'Bearer ' . self::get_token(),
    ];
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
      'lubot_master' =>  $config->LUBOT_MASTER_API  ?? 'http://localhost:8001/api',
      'BEARER_TOKEN' =>  $config->BEARER_LUBOT_MASTER ?? "8lbA52huHchhbswplKpH0OcUsr+QIgFZRkfdNsYUGhk="
    ];
    return  $data[$key];
  }
  // filtro de paises 
  public static function con_pais($nombre, $name = false)
  {
    try {
      $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::url('lubot_master_url') . "pais/{$nombre}");
      $data = json_decode($response, true);
      if ($name) return $data['nombre'] ??  "todas";
      return $data['id'] ?? 0;
    } catch (Exception  $e) {
      $response = $e;
    }
  }

  public static function con_ciudad($nombre, $name = false)
  {
    try {
      $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::url('lubot_master_url') . "ciudad/{$nombre}");
      $data = json_decode($response, true);
      if ($name) return $data['nombre'] ?? "todas";
      return $data['id'] ?? 0;
    } catch (Exception  $e) {
      $response = $e;
    }
  }

  public static function con_barrios($nombre, $name = false)
  {
    try {
      $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::url('lubot_master_url') . "barrios/{$nombre}");
      $data = json_decode($response, true);
      if ($name) return $data['nombre'] ??  "todas";
      return $data['id'] ?? 0;
    } catch (Exception  $e) {
      $response = $e;
    }
  }

  public static function con_tipo_negocio($nombre, $name = false)
  {
    try {
      $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::url('lubot_master_url') . "tipo_negocio/{$nombre}");
      $data = json_decode($response, true);
      if ($name) return $data['nombre'] ??  "todas";
      return $data['id'] ?? 0;
    } catch (Exception  $e) {
      $response = $e;
    }
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


    $lubot_master = self::url('lubot_master');
    $data = [
      'ejecutable_inicio_sesion' => "{$lubot_master}/bot/start-session",
      'activar_ejecutable_ws' => "{$lubot_master}/bot/start-ws",
      'activar_ejecutable_ryc' => "{$lubot_master}/bot/start-rc",
      'paises'  => "{$lubot_master}/utils/countries",
      'segmentos'  => "{$lubot_master}/utils/business-type",
      'barrios'  => "{$lubot_master}/utils/neighborhoods",
      'ciudades'  => "{$lubot_master}/utils/cities",
      'base_de_datos_externa' => "{$lubot_master}/utils/save-data-customer"
    ];
    return  $data[$key];
  }

  //activa el ws
  public static function activar_ws($company_id, $campains_id)
  {
    Log::info('activar_ws');
    $response = [];
    try {
      $response = Http::withHeaders(self::get_headers())
        ->get(HelperController::endpoiny('activar_ejecutable_ws') . "/{$company_id}/{$campains_id}/{$company_id}");
      return $response;
    } catch (Exception  $e) {
      Log::info('activar_ws');
      Log::info('error en ws linea 159');
      Log::info($e);
      return json_encode(
        [
          'status' => 500,
          'reponse' =>  'error',
          'response_bot' => $response,
        ]
      );
    }
  }

  public static function activar_rc($company_id, $campains_id)
  {
    Log::info('activar_ws');
    $response = "";
    try {
      $response = Http::withHeaders(self::get_headers())
        ->get(HelperController::endpoiny('activar_ejecutable_ryc') . "/{$company_id}/{$campains_id}/{$company_id}");
      return $response;
    } catch (Exception  $e) {
      Log::info('error en rc linea 159');
      Log::info($e);
      Log::info('activar_ws');
      return json_encode(
        [
          'status' => 500,
          'reponse' =>  'error',
          'response_bot' => $response,
        ]
      );
    }
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
  public static function paises()
  {
    $response =  Http::withHeaders(self::get_headers())
      ->get(self::endpoiny('paises'));
    $data = json_decode($response, true);
    return $data['data'];
  }

  public static function tipo_de_negocio()
  {
    $response =  Http::withHeaders(self::get_headers())
      ->get(self::endpoiny('segmentos'));
    $data = json_decode($response, true);
    return $data['data'];
  }

  public function barrios()
  {
    $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::endpoiny('barrios'));
    $data = json_decode($response, true);
    return $data['data'];
  }

  public function ciudades()
  {
    $response = Http::withHeaders(['Accept' => 'application/json'])->get(self::endpoiny('ciudades'));
    $data = json_decode($response, true);
    return $data;
  }
}
