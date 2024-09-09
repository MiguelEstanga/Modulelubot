<?php

namespace Modules\Lubot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Controllers\AccountBaseController;
use App\View\Components\Auth;
use Modules\Lubot\Http\Controllers\HelperController;
use Illuminate\Support\Facades\DB;
use Exception;

class EditController extends AccountBaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function propmps($id)
    {
        $propms = DB::table('prompts')->where('id', $id)->first();
        return json_encode($propms);
    }

    public function propmps_actualizar($id, Request $request)
    {
        $propms = [];
        try {
            $propms = DB::table('prompts')->where('id_campanas', $id)->update(
                [
                    'prompt' => json_encode( $request->get('prompts'))
                ]
            );
        } catch (Exception  $e) {
            $response = $e;
            return json_encode([
                'status' => 500,
                'message' => $response,
                'id' => $id,
                'colummna' => $propms   
            ]);
        }

        return json_encode([
            'status' => 200,
            'message' => 'Prompts actualizado correctamente',
            'id' => $id,
            'propms' =>$request->all()
        ]);
    }
}
