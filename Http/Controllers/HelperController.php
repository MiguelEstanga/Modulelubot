<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HelperController extends Controller
{
  public static function url($key)
  {
    $data = [
        'WEB_HOOK_RUL' => "https://2624-186-114-249-60.ngrok-free.app/api",
        'lubot_master' => "https://lubot.healtheworld.com.co/api"
    ];
    return  $data[$key];
  }
  public static function public($key)
  {
    $data =  [
      'logo' =>  asset('lubot_icon.png'),
      'requiest' =>  asset('request.png'),
    ];
    return $data[$key];
  }
  public static function endpoiny($key)
  {
    //$web_hook = self::url('lubot_master'); produccion
    $web_hook = self::url('WEB_HOOK_RUL'); // desarrollo
    $lubot_master = self::url('lubot_master');
    $data = [
        'ejecutable_inicio_sesion' => "{$web_hook}/activar_inicio_session",
        'activar_ejecutable_ws' => "{$web_hook}/activar_ejecutable_ws",
        'paises'  => "{$lubot_master}/paises",
        'segmentos'  => "{$lubot_master}/tipos_negocios",
        'barrios'  => "{$lubot_master}/barrios",
        'ciudades'  => "{$lubot_master}/ciudades",
    ];
    return  $data[$key];
  }
}
