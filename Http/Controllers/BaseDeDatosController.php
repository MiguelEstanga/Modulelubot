<?php

namespace Modules\Lubot\Http\Controllers;

;
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
    public function index( DbTable $dataTable )
    {
        $this->data['db'] = DB::table('user_db' )->where('id_companies' , $this->data['company']['id'] )->get();
       
        $this->data['logo'] = HelperController::public('logo');
        $this->data['requiest'] = HelperController::public('requiest');

        return $dataTable->ConId($this->data['company']['id'])
                         ->render('lubot::bd.index' , $this->data);
    }


    public function store(Request $request)
    {
        if($request->hasFile('file'))
        {
            $path = $request->file('file')->store('temp'); 
            $fullPath = Storage::path($path);

             $data = Excel::toCollection(null, $fullPath)->first();
            $data_parse = [];

           for( $i = 0 ; $i< count($data) ; $i++ )
           {
                for($j = 0 ; $j < count($data[0]) ; $j++ )
                {   
                    if($i != 0)
                    {   
                        $data_parse[$i][$data[0][$j]] = $data[$i][$j];
                    }
                    
                }
                
           }
           $db_user =  DB::table('user_db')->insertGetId([
                'id_companies' => $this->data['company']['id'],
                'nombre' => $request->bd_name
            ]);

            
            DB::table('data_db')->insert([
                'id_companies' => $this->data['company']['id'],
                'id_db' => $db_user,
                'data' => json_encode($data_parse)
            ]);
          
        }
        return back();
    }

    public function show( $id_db )
    {
        $db =  DB::table('data_db')->where('id_db' , $id_db)->first();
          $this->data['db_data'] = json_decode($db->data , true );
        return  view('lubot::bd.table' , $this->data);
     
    }
    
    public function delete($id)
    {
        
        DB::table('user_db')->where('id' , $id)->delete();
        return back();
    }
}
