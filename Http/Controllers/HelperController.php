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
        'WEB_HOOK_RUL' => "https://acff-186-112-18-249.ngrok-free.app/api",
        'lubot_master' => "https://lubot.healtheworld.com.co/api" 
    ];
    return  $data[$key];
  }
  public static function public($key)
  {
    $data =  [
      'logo' =>  'https://res.cloudinary.com/deq9rulqu/image/upload/v1723675402/lubot_icon_ovm7y2.png',//asset('lubot_icon.png'),
      'requiest' =>  'https://res.cloudinary.com/deq9rulqu/image/upload/v1723675399/request_aohokz.png'//asset('request.png'),
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
}
