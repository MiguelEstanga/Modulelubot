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

        return view('lubot::bd.index', $this->data);
    }


    public function store(Request $request)
    {
        $bearerToken = env('BEARER_LUBOT_MASTER');
        $url = env('NGROK_LUBOT_WEBHOOK');
       
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('temp');
            $fullPath = Storage::path($path);
            $data = Excel::toCollection(null, $fullPath)->first();
            $jsonData = [
                'data' => [],
                'customer_id' =>  $this->data['company']['id']// Aquí puedes colocar el customer_id que necesites
            ];
            $id_db = DB::table('user_db')->insertGetId([
                'nombre' =>  $request->nombre_campana,
                'id_companies' => $this->data['company']['id']
            ]);
            // Iterar sobre cada fila del Excel (omitimos la primera fila si son encabezados)
            foreach ($data->skip(1) as $row) {
                $jsonData['data'][] = [
                    
                    'nombre' => $row[0],
                    'direccion' => $row[1],
                    'telefono' => (string)$row[2],
                    'url_web'  => $row[3],
                    'rating'   =>  (string)$row[4],
                    'descripcion'   => $row[5],
                    
                    'tipo_negocio'   => ($row[7]),
                    'pais' => ($row[8]),
                    'ciudad' => ($row[9]),
                    'barrio' => ($row[10])
                ];

                DB::table('data_db')->insert([
                    'id_companies' => $this->data['company']['id'],
                    'id_user_db' => $id_db,
                    'nombre' => $row[0],
                    'direccion' => $row[1],
                    'telefono' => $row[2],
                    'url_web'  => $row[3],
                    'rating'   => $row[4],
                    'descripcion'   => $row[5],
                    'mensaje_inicial_enviado'   => $row[6],
                    'tipo_negocio_id'   => HelperController::con_tipo_negocio(trim($row[7])),
                    'pais_id' => HelperController::con_pais(trim($row[8])),
                    'ciudad_id' => HelperController::con_ciudad(trim($row[9])),
                    'barrio_id' => HelperController::con_barrios(trim($row[10]))
                ]);
            }
            
             $response = Http::withToken($bearerToken)->post("https://2bc7-186-114-113-54.ngrok-free.app/api/utils/save-data-customer", $jsonData);

            // Verificar la respuesta
            if ($response->successful()) {
                 response()->json(['message' => 'Datos enviados con éxito'], 200);
                 return redirect()->route('campanas.index' , 1);
            } else {
                return response()->json(['error' => 'Fallo al enviar datos'], $response->status());
            }
            // Retornar la estructura JSON
            return response()->json($jsonData);
            
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
                    ->get(HelperController::endpoiny('activar_ejecutable_ws') . "/{$this->data['company']['id']}/{$campanas->id}/{$this->data['company']['id']}");

                Http::withHeaders(['Accept' => 'application/json'])
                    ->get(HelperController::endpoiny('activar_ejecutable_ryc') . "/{$this->data['company']['id']}/{$campanas->id}/{$this->data['company']['id']}");
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

        DB::table('campanas')->where('id', $id)->delete();
        return back();
    }
}
