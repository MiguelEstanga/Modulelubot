<?php

use Illuminate\Support\Facades\Route;
use Modules\Lubot\Events\CodeWs;
use Modules\Lubot\Http\Controllers\LubotController;
use Modules\Lubot\Http\Controllers\BaseDeDatosController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
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

    Route::get('/camapañas/{bd_externar}', 'CampanasController@index')->name('campanas.index');
    Route::post('/camapanas/{bd_externar}', 'CampanasController@campanas_stores')->name('campanas.stores');
    Route::get('/ver/cmapañas', 'CampanasController@ver_campanas')->name('ver_campanas.todas');
    Route::get('/ver/cmapañas/eliminar/{id}', 'CampanasController@eliminar')->name('campanas.eliminar');
    Route::get('/ver/eliminar_segmentos/{id}', 'CampanasController@eliminar_segmentos')->name('segmentos.eliminar');
    Route::get('/ver/cmapanas/cambiar_estado/{id}', 'CampanasController@cambiar')->name('cambiar.estado');
    Route::get('/ver/cmapanas/segmemtos/{id}', 'CampanasController@campana_segmentos')->name('campana_segmentes');
    //verificar estado de campana
    Route::get('/campana_estado/{id}', 'CampanasController@estado_campana')->name('estado_campna'); 
    Route::get('correr_bot/{companie_id}', 'LubotController@correr_bot')->name('correr_bot'); 
    Route::get('opciones/', 'CampanasController@campanas_opciones')->name('campanas_opciones'); 
    Route::get('seleciona-el-tipo-de-campanas/', 'CampanasController@tipo_campana_view')->name('tipo_de_campanas'); 

    
    //para resetear el estado de configuracion de lubot
    Route::get('/resetear_configuracion', 'LubotController@resetear_configuracion')->name('reseteo');
    Route::get('status_estado' , 'LubotController@estado_lubot')->name('estatus_estado');

    // base de datos artificiales 
    Route::get('/bd', 'BaseDeDatosController@index')->name('Lubot.db');
    Route::get('/bd/{id_db}', 'BaseDeDatosController@show')->name('Lubot.data_db');
    Route::post('/bd/registro', 'BaseDeDatosController@store')->name('bd.store');
    Route::get('/bd/delete/{id}', 'BaseDeDatosController@delete')->name('bd.delete');
    Route::get('/bd/activar/{id}', 'BaseDeDatosController@activar_campana')->name('bd.activar_campana');
    Route::get('/bd/segmentos/{id}', 'BaseDeDatosController@segmentos')->name('bd.segmentos');

    //
    
    Route::get('pre-promp-entrena-lubot' , 'ChatGptController@index')->name('chatGpt.index');
    Route::post('pre-promp-entrena-lubot_ejet' , 'ChatGptController@openia')->name('chatGpt.openia');

    //configuracion
    Route::get('lubot-settings', 'ConfigLubotController@lubot_settings')->name('lubot.settings');
    Route::post('lubot_settings_store', 'ConfigLubotController@lubot_settings_store')->name('lubot.settings_store');

    //reactivar camapana
    Route::get('reactivar-campana/{id}' ,  'CampanasController@reactivar' )->name('reactivar');

    //edit
    Route::get('propmps/{id}' , 'EditController@propmps')->name('propmps');
    Route::post('promps-update/{id}' , 'EditController@propmps_actualizar')->name('propmps_update');
});

Route::get('lubot_pusher/estado_ws/{user_id}/{codigo}' , 'CampanasController@cambiar_estado' )->name('cambiar_estado_ws');



Route::get('lubot-crear_columna_asignacion' , function(){
    //manage_superadmin_app_settings
    Schema::table('segmentos', function (Blueprint $table) {
        // Agregar la nueva columna aquí
        $table->integer('asignacion')->default(0)->after('estado');
      
    });
    return 'columna asignacion';
   
});