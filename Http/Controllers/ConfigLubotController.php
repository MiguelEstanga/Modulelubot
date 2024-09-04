<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use  Modules\Lubot\Http\Controllers\HelperController;
use App\Http\Controllers\AccountBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;
class ConfigLubotController  extends AccountBaseController
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

    public function lubot_settings()
    {
        $this->data['pageTitle'] = 'configuracion';
        $this->data['pageDescription'] = [];
     $this->data['configuracion'] = DB::table('lubot_settings')->where('id_companie', $this->data['company']['id'])->first() ?? [];
      
        return view('lubot::notification-settings.configuracion', $this->data);
    }

    public function migracion_automatica()
    {
        if (!Schema::hasTable('lubot_settings')) {
            Schema::create('lubot_settings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_companie');
                $table->string('LUBOT_MASTER_API');
                $table->string('LUBOT_MASTER');
                $table->string('NGROK_LUBOT_WEBHOOK');
                $table->string('BEARER_LUBOT_MASTER');
            });

            DB::table('lubot_settings')->insert([
                'id_companie' => $this->data['company']['id'],
                'LUBOT_MASTER_API' => 'https://lubot.healtheworld.com.co/api',
                'LUBOT_MASTER' => 'https://lubot.healtheworld.com.co/',
                'NGROK_LUBOT_WEBHOOK' => 'https://2c09-186-112-18-249.ngrok-free.app/api',
                'BEARER_LUBOT_MASTER' => '8lbA52huHchhbswplKpH0OcUsr+QIgFZRkfdNsYUGhk=',
            ]);
        }
    }

    public function lubot_settings_store(Request $request)
    {
        // por si no se carga la migracion de forma automatica
        $this->migracion_automatica();

        try {
            $config = DB::table('lubot_settings')->where('id_companie', $this->data['company']['id'])->exists();
            if (!$config) {
                DB::table('lubot_settings')->insert([
                    'id_companie' => $this->data['company']['id'],
                    'LUBOT_MASTER_API' => $request->url_master,
                    'LUBOT_MASTER' => $request->LUBOT_MASTER,
                    'NGROK_LUBOT_WEBHOOK' => $request->NGROK_LUBOT_WEBHOOK,
                    'BEARER_LUBOT_MASTER' => $request->BEARER_LUBOT_MASTER,
                ]);
            } else {
                DB::table('lubot_settings')->where('id_companie', $this->data['company']['id'])->update([
                    'id_companie' => $this->data['company']['id'],
                    'LUBOT_MASTER_API' => $request->url_master,
                    'LUBOT_MASTER' => $request->LUBOT_MASTER,
                    'NGROK_LUBOT_WEBHOOK' => $request->NGROK_LUBOT_WEBHOOK,
                    'BEARER_LUBOT_MASTER' => $request->BEARER_LUBOT_MASTER,
                ]);
            }
        } catch (Exception $e) {
            return response()->json(['success' => 500, 'mesange' => "Error"]);
        }

        return response()->json(['success' => 200, 'mesange' => "actulizacion lista"]);
        
    }
}
