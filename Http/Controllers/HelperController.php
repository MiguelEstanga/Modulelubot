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

  public static function endpoiny($key)
  {
    $web_hook = self::url('WEB_HOOK_RUL');
    $lubot_master = self::url('lubot_master');
    $data = [
        'activar_ws' => "{$web_hook}/activar_ws",
        'activar_rc' => "{$web_hook}/activar_rc",
        'paises'  => "{$lubot_master}/paises",
        'segmentos'  => "{$lubot_master}/tipos_negocios",
        'barrios'  => "{$lubot_master}/barrios",
        'ciudades'  => "{$lubot_master}/ciudades",
    ];
    return  $data[$key];
  }
}
