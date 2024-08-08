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
    ];
    return  $data[$key];
  }

  public static function endpoiny($key)
  {
    $web_hook = self::url('WEB_HOOK_RUL');
    $data = [
        'activar_ws' => "{$web_hook}/activar_ws",
        'activar_rc' => "{$web_hook}/activar_rc",
    ];
    return  $data[$key];
  }
}
