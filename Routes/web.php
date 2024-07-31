<?php

use Illuminate\Support\Facades\Route;
use Modules\Lubot\Events\CodeWs;
use Modules\Lubot\Http\Controllers\LubotController;
use Pusher\Pusher;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('lubot')->group(function() {
    Route::get('/', 'LubotController@index')->name('lubot.admin');
    Route::get('/activacion', 'LubotController@Activacion')->name('lubot.admin');
    Route::post('/activacion', [LubotController::class , 'activacion_post'])->name('lubot.activacion');
    Route::get('/activacion/default', [LubotController::class , 'datas_compania'])->name('lubot.default_compania');

    //Route::get('/activacion', 'LubotController@Activacion')->name('lubot.admin');
    Route::get('/get_row', 'CampanasController@get_segmentos_fila')->name('campanas.get_row');

    Route::get('/camapañas', 'CampanasController@index')->name('campanas.index');
    Route::post('/camapañas', 'CampanasController@campanas_stores')->name('campanas.stores');
    Route::get('/ver/cmapañas', 'CampanasController@ver_campanas')->name('ver_campanas.todas');
    Route::get('/ver/cmapañas/eliminar/{id}', 'CampanasController@eliminar')->name('campanas.eliminar');
    Route::get('/ver/cmapanas/cambiar_estado/{id}', 'CampanasController@cambiar')->name('cambiar.estado');
    Route::get('/ver/cmapanas/segmemtos/{id}', 'CampanasController@campana_segmentos')->name('campana_segmentes');
    Route::get('test', 'LubotController@probar')->name('probarbot'); 

    Route::get('evento' , function(){
        CodeWs::dispatch();
        event(new CodeWs);
        return env('LUBOT_PUENTE');
    });
});

Route::get('lubot_pusher/estado_ws/{user_id}/{codigo}' , function($user_id , $estado){
        
        if($estado === 0 )  DB::table('config_lubots')->where('id_companies' , $user_id )->update(['estado_ws' => 0 ]);
        if($estado === 1 )  DB::table('config_lubots')->where('id_companies' , $user_id )->update(['estado_ws' => 1 ]);
        if($estado === 2 )  DB::table('config_lubots')->where('id_companies' , $user_id )->update(['estado_ws' => null ]);
        if($estado > 2) return response()->json(['success' => 'este estado no existe']);

        $options = array(
            'cluster' => 'us2',
            'useTLS' => true
          );

        $pusher = new Pusher(
            '9f29c49b324e84800f64',
            '6b56bf5a2d2bdb65f795',
            '1842818',
            $options
          );
        
        $pusher->trigger("user_estado_{$user_id}" , "user_{$user_id}" , array('mensage' =>  $estado ) );
        CodeWs::dispatch();
        event(new CodeWs);
        return response()->json([
            'success' => 'evento terminado'
        ]);
        
})->name('cambiar_estado_ws');
