<?php

namespace Modules\Lubot\Http\Controllers;;

use App\Http\Controllers\AccountBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Lubot\DataTables\DbTable;
use Modules\Lubot\DataTables\SegmentosTable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Modules\Lubot\Http\Controllers\HelperController;
use Exception;

class BaseDeDatosController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = '';
        $this->activeSettingMenu = '';
        $this->middleware(
            function ($request, $next) {
                //  abort_403(!in_array('balance', $this->user->modules));
                return $next($request);
            }
        );
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->data['db'] = DB::table('user_db')
            ->where('id_companies', $this->data['company']['id'])
            ->get() ?? [];
        $this->data['logo'] = HelperController::public('logo');
        $this->data['requiest'] = HelperController::public('requiest');
        $this->data['url_segmentos'] = HelperController::endpoiny('segmentos');
        return view('lubot::bd.index', $this->data);
    }

    function limpiar_texto($texto)
    {
        // Convertir el texto a UTF-8 para asegurar una correcta manipulación de caracteres especiales
        $texto = utf8_encode($texto);

        // Expresión regular para eliminar números, espacios, caracteres especiales y acentos
        $patron = '/[^a-zA-Z]+/';

        // Reemplazar los caracteres que coincidan con el patrón por una cadena vacía
        $texto_limpio = preg_replace($patron, '', $texto);

        return $texto_limpio;
    }

    public function store(Request $request)
    {
      //  return HelperController::endpoiny('base_de_datos_externa');
        $bearerToken = env('BEARER_LUBOT_MASTER');
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('temp');
            $fullPath = Storage::path($path);
            $data = Excel::toCollection(null, $fullPath)->first();
            $jsonData = [
                'data' => [],
                'customer_id' =>  $this->data['company']['id'] // Aquí puedes colocar el customer_id que necesites
            ];
            $id_db = DB::table('user_db')->insertGetId([
                'nombre' =>  $request->nombre_campana,
                'id_companies' => $this->data['company']['id']
            ]);
            // Iterar sobre cada fila del Excel (omitimos la primera fila si son encabezados)
            $dataToInsert = [];
            foreach ($data->skip(1) as $row) {
                $jsonData['data'][] = [
                    'nombre' => $row[0],
                    'direccion' => $row[1],
                    'telefono' => (string)$row[2],
                    'url_web'  => $row[3],
                    'rating'   =>  (string)$row[4],
                    'descripcion'   => $row[5],
                    'tipo_negocio'   => $row[7],
                    'pais' => ($row[8]),
                    'ciudad' => ($row[9]),
                    'barrio' => ($row[10])
                ];
              
                $dataToInsert[] = [
                    'id_companies' => $this->data['company']['id'],
                    'id_user_db' => $id_db,
                    'nombre' => $row[0],
                    'direccion' => $row[1],
                    'telefono' => $row[2],
                    'url_web'  => $row[3],
                    'rating'   => $row[4],
                    'descripcion'   => $row[5],
                    'mensaje_inicial_enviado'   => $row[6],
                    'tipo_negocio_id'   => 0,//trim($row[7]),
                    'pais_id' => trim($row[8]),
                    'ciudad_id' => trim($row[9]),
                    'barrio_id' => trim($row[10]),
                ];
            }
            DB::table('data_db')->insert($dataToInsert);
            return 0;
            $jsonData;
            try {
                $response = Http::withToken(HelperController::get_token())
                    ->timeout(3)
                    ->post(HelperController::endpoiny('base_de_datos_externa'), json_encode($jsonData));
            
                if ($response->successful()) {
                    return response()->json(['message' => 'Datos enviados con éxito'], 200);
                } else {
                    return response()->json(['error' => 'Fallo al enviar datos'], $response->status());
                }
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                return response()->json(['error' => 'Error de conexión: ' . $e->getMessage()], 500);
            }
            DB::table('data_db')->insert($dataToInsert);
           
           
            
            // Retornar la estructura JSON
            return back()->with('mensage' , 'La base de datos a sido creada correctamente ');

            //local


        }
    }

    public function show($id_db, DbTable $dataTable)
    {
        return  $dataTable->ConId($id_db)->render('lubot::bd.table', $this->data);
    }

    public function activar_campana($id)
    {
        $campanas = DB::table('campanas')->where('id', $id)->first();
        if ($campanas->encendido == 0) {
            DB::table('campanas')->where('id', $id)->update(['encendido' => 1]);
            try {
                $response = Http::withHeaders(['Accept' => 'application/json'])
                    ->get(HelperController::endpoiny('activar_ejecutable_ws', $this->data['company']['id']) . "/{$this->data['company']['id']}/{$campanas->id}/{$this->data['company']['id']}");

                Http::withHeaders(['Accept' => 'application/json'])
                    ->get(HelperController::endpoiny('activar_ejecutable_ryc', $this->data['company']['id']) . "/{$this->data['company']['id']}/{$campanas->id}/{$this->data['company']['id']}");
            } catch (Exception  $e) {
                $response = $e;
            }
        } else {
            DB::table('campanas')->where('id', $id)->update(['encendido' => 0]);
        }

        return back();
    }

    public function segmentos($id)
    {
        $this->activeMenu = 'Mi base de datos';

        return view('lubot::bd.table', $this->data);
    }
    public function delete($id)
    {
        // Elimina todos los registros relacionados en 'data_db' en una sola operación
        DB::table('data_db')->where('id_user_db', $id)->delete();

        // Luego elimina el registro del usuario
        DB::table('user_db')->where('id', $id)->delete();

        return back();

        //$db->delete();

        return back();
    }
}
