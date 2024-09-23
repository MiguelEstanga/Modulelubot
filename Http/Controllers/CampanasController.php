<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Controllers\AccountBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Lubot\DataTables\CampanaTable;
use Modules\Lubot\DataTables\SegmentosTable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;
use  Modules\Lubot\Http\Controllers\HelperController;

class CampanasController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();


        $this->pageTitle = 'app.menu.balance_admin';
        $this->activeSettingMenu = 'front_theme_settings';
        $this->data['logo'] =  HelperController::public('logo');

        $this->middleware(
            function ($request, $next) {
                //  abort_403(!in_array('balance', $this->user->modules));
                return $next($request);
            }
        );
    }

    public function index($bd_externar)
    {
        
        $this->data['url_activar_rc'] = HelperController::endpoiny('ejecutable_inicio_sesion', $this->data['company']['id'])."/{$this->data['company']['id']}/rc";
        $this->data['campana_store'] = route('campanas.stores', $bd_externar);
        $this->data['bd_externar'] = $bd_externar;  
        $this->data['config_lubot'] = DB::table('config_lubots')->where('id_companies', $this->data['company']['id'])->first();
        $this->data['companie'] =       $this->data['company']['id'];
         $this->data['segmentos'] =      HelperController::tipo_de_negocio();
        $this->data['objetivos'] =      DB::table('objetivos_lubot')->get() ?? [];
        $this->data['loadBarrios'] =    HelperController::endpoiny('barrios');
        $this->data['loadCiudad'] =     HelperController::endpoiny('ciudades');
        $this->data['paises'] =        HelperController::paises() ;
        $this->data['bearer'] =        HelperController::get_token();
        $this->activeMenu = 'lubot';
        //return HelperController::endpoiny('activar_ejecutable_ws') . "/1/1/1";
        Log::info('Este es un mensaje de información');

        return view('lubot::campanas.index', $this->data);
    }

    public function ststus_code_error($mensage)
    {
        return json_encode(['status' => 'error', 'message' => $mensage]);
    }
    public function campanas_stores($bd_externar, Request $request)
    {
       
        if ($bd_externar == 0) {
            if (count($request->barrios) == 0) return json_encode([
                'status' => 'error',
                'message' => 'No hay barrios para seleccionar'
            ]);
            if (count($request->ciudades) == 0) return json_encode([
                'status' => 'error',
                'message' => 'No hay ciudades para seleccionar'
            ]);
            if (count($request->paises) == 0) return json_encode([
                'status' => 'error',
                'message' => 'No hay paises para seleccionar'
            ]);
        }

        if ($request->frecuencia < 0 || $request->frecuencia === null) return json_encode(['status' => 'error', 'message' => 'Digite una Frecuencia correcta']);
        if ($request->spbre_la_empresa === null) return json_encode(['status' => 'error', 'message' => 'Sobre la empresa  no puede ser un campo vacio']);
        if ($request->como_me_llamo === "" || $request->como_me_llamo === null) return json_encode(['status' => 'error', 'message' => 'Elija un nombre para su Lubot']);


        date_default_timezone_set('America/Bogota');
        $paises = array();
        $ciudades = array();
        $barrios = array();
        $cantidad = array();
        $tipo_de_negocio = $bd_externar === 0 ?  $request->segmento : '';
        $objetivo_lubot = $request->objetivo_lubot;
        $como_me_llamo = $request->como_me_llamo;
        $frecuencia = $request->frecuencia;
        $plan = $request->plan;
        $temporalidad = $request->temporalidad;
        $spbre_la_empresa = $request->spbre_la_empresa;
        $nombre_campana = $request->nombre_campana;
        $preguntas_respuestas = $request->preguntas_respuestas ?? 'saludo generico';


        for ($i = 0; $i < count($preguntas_respuestas); $i++) {
            if ($preguntas_respuestas[$i]['pregunta'] === null) {
                $numero = $i + 1;
                return $this->ststus_code_error("La pregunta numero {$numero} no puede estar vacia eliminela o coloque un msm");
            }

            if ($preguntas_respuestas[$i]['respuesta'] === null) {
                $numero = $i + 1;
                return $this->ststus_code_error("La respuesta numero {$numero} no puede estar vacia eliminela o coloque un msm");
            }
        }

        if ($bd_externar == 0) {
            foreach ($request->paises as $pais) {

                $paises[] = $pais['id'];
            }

            foreach ($request->ciudades as $ciudad) {

                $ciudades[] = $ciudad['id'];
            }

            foreach ($request->barrios as $barrio) {
                $barrios[] = $barrio['id'];
            }
            foreach ($request->cantidades as $cantidad) {

                $cantidades[] = $cantidad['cantidad'];
            }
        }


        try {
            $campana_id = DB::table('campanas')->insertGetId(
                [
                    'id_companies' => $this->data['company']['id'],
                    'nombre' => $nombre_campana,
                    'objetivo_de_lubot' => $objetivo_lubot === 0 ? 1 : $objetivo_lubot,
                    'como_me_llamo' => $como_me_llamo,
                    'frecuencia' => $frecuencia,
                    'tipo_negocio' => $bd_externar === 0 ?  $tipo_de_negocio : 0,
                    'spbre_la_empresa' => $spbre_la_empresa,
                    'temporalidad' =>  $temporalidad,
                    'credito' => 30,
                    'db_externa' => $bd_externar
                ]
            );
        } catch (Exception  $e) {
            $response = $e;
        }


        try {
            DB::table('campaign_schedules')->insertGetID([
                "campaign_id" => $campana_id,
                "companie_id" =>  $this->data['company']['id'],
                "frequency_number" => $frecuencia,
                "frequency_unit" => $temporalidad,
                "next_run_at" => HelperController::calculateNextRun($frecuencia, $temporalidad),

            ]);
        } catch (Exception  $e) {
            $response = $e;
        }

        if ($bd_externar == 0) {
            try {
                for ($i = 0; $i <= count($paises) - 1; $i++) {
                    $segmento_id = DB::table('segmentos')->insertGetId(
                        [
                            'id_campanas' =>  $campana_id,
                            'tipo_de_negocio' => $tipo_de_negocio,
                            'ciudad' =>  $ciudades[$i],
                            'pais'  =>  $paises[$i],
                            'barrio'   => $barrios[$i],
                            'cantidad' => $cantidades[$i]
                        ]
                    );

                    DB::table('consumo_creditos')->insert(
                        [
                            'id_campana' =>  $campana_id,
                            'id_segmento' => $segmento_id,
                            'creditos_consumidos' =>  0,
                            'creditos_restantes' => 30
                        ]
                    );
                }
            } catch (Exception  $e) {
                $response = $e;
            }
        }


        try {
            DB::table('prompts')
                ->insert(
                    [
                        'prompt' =>  json_encode($preguntas_respuestas),
                        'id_campanas' =>  $campana_id,
                    ]
                );
        } catch (Exception  $e) {
            $response = $e;
        }
        self::actualizarAsignacionSegmentos($campana_id);

        try {
           
            HelperController::activar_ws( $this->data['company']['id'] , $campana_id );
            HelperController::activar_rc( $this->data['company']['id'] , $campana_id );
        } catch (Exception  $e) {
            return json_encode(
                [
                    'status' => 500,
                    'reponse' =>  'error',
                    'response_bot' => $response,
                ]
            );
        }
        return json_encode(
            [
                'status' => 200,
                'reponse' =>  'ok',
                'route' => route('ver_campanas.todas')
            ]
        );
    }

    public static function actualizarAsignacionSegmentos($campana_id)
    {
        // Obtener la campaña específica
        $campana =  DB::table('campanas')->where('id', $campana_id)->first(); //Campana::with('segmentos')->findOrFail($idCampana);

        // Supongamos que este es el número de mensajes que se pueden enviar semanalmente
        $frecuencia = $campana->frecuencia;

        // Filtrar solo los segmentos activos (estado = 1)
        $segmentos = DB::table('segmentos')->where('id_campanas', $campana_id)->where('estado', 1)->get() ?? [];

        // Número total de segmentos activos
        $segmentosActivos = count($segmentos);

        // Reparto inicial: dividir la frecuencia entre los segmentos
        if ($segmentosActivos === 0) {
            $repartoInicial = floor($frecuencia / 1);
        } else {
            $repartoInicial = floor($frecuencia / $segmentosActivos);
        }



        // Array para almacenar las asignaciones
        $mensajesAsignados = [];

        // Variable para acumular los mensajes sobrantes
        if($segmentosActivos === 0 )
        {
            $mensajesSobrantes =  $frecuencia % 1; // Esto te da 2;

        }else{
            $mensajesSobrantes =  $frecuencia % $segmentosActivos; // Esto te da 2;

        }
        
        // Primera ronda de asignación de mensajes
        foreach ($segmentos as $segmento) {
            $cantidadRestante = $segmento->cantidad - $segmento->cantidad_consumida;

            if ($repartoInicial <= $cantidadRestante) {
                // Si el reparto inicial no supera la cantidad restante, asignar directamente
                $mensajesAEnviar = $repartoInicial;
            } else {
                // Si supera, asignar solo los mensajes que quedan disponibles para el segmento
                $mensajesAEnviar = $cantidadRestante;
                // Los mensajes sobrantes se acumulan para redistribuirlos
                $mensajesSobrantes += ($repartoInicial - $cantidadRestante);
            }

            // Almacenar los mensajes asignados en un array
            $mensajesAsignados[] = [
                'id_segmento' => $segmento->id,
                'mensajes_a_enviar' => $mensajesAEnviar,
            ];
        }
        // Segunda ronda: redistribuir mensajes sobrantes
        foreach ($mensajesAsignados as &$asignacion) {
            if ($mensajesSobrantes > 0) {
                // Buscar el segmento original
                $segmento = DB::table('segmentos')->where('id', $asignacion['id_segmento'])->first();
                $cantidadRestante = $segmento->cantidad - $segmento->cantidad_consumida - $asignacion['mensajes_a_enviar'];

                // Asignar mensajes sobrantes si el segmento aún tiene espacio
                if ($cantidadRestante > 0) {
                    $asignarSobrantes = min($mensajesSobrantes, $cantidadRestante);
                    $asignacion['mensajes_a_enviar'] += $asignarSobrantes;
                    $mensajesSobrantes -= $asignarSobrantes;
                }
            }
        }

        // Actualizar la base de datos
        for ($i = 0; $i < count($mensajesAsignados); $i++) {
            DB::table('segmentos')->where('id', $mensajesAsignados[$i]['id_segmento'])->update(['asignacion' => $mensajesAsignados[$i]['mensajes_a_enviar']]);
        }


        // Devolver el resultado o mostrar los mensajes enviados
        return response()->json([
            'asignaciones' => $mensajesAsignados,
            'mensajes_sobrantes' => $mensajesSobrantes
        ]);
    }



    public function reactivar($campana_id)
    {

        self::actualizarAsignacionSegmentos($campana_id);
        try {
            HelperController::activar_ws( $this->data['company']['id'] , $campana_id );
            HelperController::activar_rc( $this->data['company']['id'] , $campana_id );
            log::info('funcion reactivar');
        } catch (Exception  $e) {
            $response = $e;
            log::info('reactivar');
            log::info($response);
        }

        //DB::table('campanas')->where('id', $campana_id)->update(['encendido' => 1]);

        return back();
    }

    public function ver_campanas(CampanaTable $dataTable)
    {
        //return  $this->data['company']['id'];
        $this->activeMenu = 'Campañas';
        $campanas =  DB::table('campanas')->where('id_companies',  $this->data['company']['id'])->get();
        //return $prompt = DB::table('prompts')->where('id_campanas', 6)->first()->prompt;
        $this->data['objetivos'] =  DB::table("objetivos_lubot")->get();
        $this->data['campanas'] = $campanas;

        return $dataTable->ConId($this->data['company']['id'])->render('lubot::campanas.campanas', $this->data);
    }


    public function eliminar($id)
    {
        $campanas =  DB::table('campanas')->where('id',  $id)->first();
        $segmentos = DB::table('segmentos')->where('id_campanas',  $id)->get();
        foreach ($segmentos as $segmento) {
            DB::table('segmentos')->where('id',  $segmento->id)->delete();
        }
        DB::table('campanas')->where('id',  $id)->delete();
        //$campanas->delete();
        return back();
    }
    //opciones 
    public function campanas_opciones()
    {
        $this->data['logo'] = HelperController::public('logo');
        return view('lubot::opciones.opciones',  $this->data);
    }

    public function cambiar($id)
    {
        // Obtén el registro de la campaña
        $campana = DB::table('campanas')->where('id', $id)->first();

        if (!$campana) {
            return response()->json([
                'status' => 404,
                'message' => 'Campaña no encontrada'
            ]);
        }

        // Cambia el estado de la campaña
        $nuevoEstado = $campana->campanas_activa === 0 ? 1 : 0;

        // Actualiza el registro en la base de datos
        DB::table('campanas')->where('id', $id)->update(['campanas_activa' => $nuevoEstado]);

        // Obtén el registro actualizado
        $campanaActualizada = DB::table('campanas')->where('id', $id)->first();

        return response()->json([
            'status' => 200,
            'campana' => $campanaActualizada
        ]);
    }

    public function estado_campana($id)
    {
        $campana = DB::table('campanas')->where('id', $id)->first();
        return json_encode($campana);
    }
    public function campana_segmentos(SegmentosTable $dataTable,  $id)
    {

        $segmentos = DB::table('segmentos')->where('id_campanas', $id)->get();

        $campana = DB::table('campanas')->where('id', $id)->first();
        $this->data['campana_id'] = $campana->id;
        $this->data['campana_estado'] = route('estado_campna', $campana->id);
        $this->data['segmentos'] = $segmentos;
        $this->data['campana'] = $campana;
        $this->data['objetivo'] =  DB::table("objetivos_lubot")->where('id', $campana->objetivo_de_lubot)->first();

        $this->data['id_companie'] =  $this->data['company']['id'];
        $this->data['url_activar_bot'] = HelperController::endpoiny('activar_ejecutable_ws');
        $dataTable->withId($id);
        return $dataTable->render('lubot::campanas.segmentos',  $this->data);
    }

    public function eliminar_segmentos($id)
    {
        DB::table('segmentos')->where('id',  $id)->delete();
        return back();
    }

    //tipo de campana view
    public function tipo_campana_view()
    {
        $this->data['logo'] = HelperController::public('logo');
        $this->data['requiest'] = HelperController::public('requiest');
        return view('lubot::campanas.tipo_de_campanas', $this->data);
    }
}
