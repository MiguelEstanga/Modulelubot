<?php 
namespace Modules\Lubot\DataTables;

use App\DataTables\BaseDataTable;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class DbTable extends BaseDataTable
{
    
    public $companie_id;
    public function ConId($id)
    {
        $this->companie_id = $id;
        return $this;
    }

  
    public function dataTable($query)
    {
        return datatables()
            ->query($query)
            ->addIndexColumn()
              ->addColumn('action', function ($row) {
                $action = '<div class="task_view">
                    <div class="dropdown">
                        <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link"
                            id="dropdownMenuLink-' . $row->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical icons"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->id . '" tabindex="0">';

                $action .= '<a href="' . route('orders.show', [$row->id]) . '" class="dropdown-item"><i class="fa fa-eye mr-2"></i>' . __('app.view') . '</a>';
                $action .= '</div>
                    </div>
                </div>';
                return $action;
            })
            ->addColumn('Nombre', function ($row) {
                return $row->nombre  ;
            })
           
            ->addColumn('Eliminar', function ($row) {
                return  '<a href="' . route('bd.delete', [$row->id]) . '" class="dropdown-item"><i class="bi bi-trash-fill"></i>Eliminar</a>';;
            })
            ->rawColumns(['action', 'Eliminar' ]); // Permitir HTML en estas columnas
    }
 
    public function query()
    {
          // Obtener los datos desde la columna 'data' de la tabla 'db_user'
          $query = DB::table('user_db')->select(['id' , 'nombre'])->where('id_companies' ,$this->companie_id );
          return $query; // Retor
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('user_db')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                       // Button::make('create'),
                        Button::make('export'),
                     //   Button::make('print'),
                      //  Button::make('reset'),
                       // Button::make('reload')
                    );
    }

    protected function getColumns()
    {
        return [
            Column::make('id')->title(__('app.id'))->visible(false),
            Column::make('Nombre')->title('Nombre de la BD'),
            Column::make('Eliminar')->title('Eliminar BD'),
        
          
        ];
    }
}
