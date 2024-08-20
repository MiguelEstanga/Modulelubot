<?php

use Illuminate\Support\Facades\Route;
use Modules\Lubot\Events\CodeWs;
use Modules\Lubot\Http\Controllers\LubotController;
use Modules\Lubot\Http\Controllers\BaseDeDatosController;

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
    Route::post('/camapanas', 'CampanasController@campanas_stores')->name('campanas.stores');
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

    //
    
    Route::get('pre-promp-entrena-lubot' , 'ChatGptController@index')->name('chatGpt.index');
    Route::get('pre-promp-entrena-lubot_ejet' , 'ChatGptController@openia')->name('chatGpt.openia');
});

Route::get('lubot_pusher/estado_ws/{user_id}/{codigo}' , 'CampanasController@cambiar_estado' )->name('cambiar_estado_ws');
