<?php 
namespace Modules\Lubot\DataTables;

use App\DataTables\BaseDataTable;
use Illuminate\Support\Facades\DB; 
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column; 

class DbTable extends BaseDataTable
{
    
    public $user_db;
    public function ConId($id)
    {
        $this->user_db = $id;
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

            ->addColumn('direccion', function ($row) {
                return $row->direccion  ;
            })

            ->addColumn('telefono', function ($row) {
                return $row->telefono  ;
            })

            ->addColumn('url_web', function ($row) {
                return $row->url_web  ;
            })

            ->addColumn('rating', function ($row) {
                return $row->rating  ;
            })
            
            ->addColumn('descripcion', function ($row) {
                return $row->descripcion  ;
            })
           
            ->addColumn('tipo_negocio_id', function ($row) {
                return $row->tipo_negocio_id  ;
            })

            ->addColumn('pais_id', function ($row) {
                return $row->pais_id  ;
            })

            ->addColumn('ciudad_id', function ($row) {
                return $row->ciudad_id  ;
            })

            ->addColumn('barrio_id', function ($row) {
                return $row->barrio_id  ;
            })

            ->addColumn('Eliminar', function ($row) {
                return  '<a href="' . route('bd.delete', [$row->id]) . '" class="dropdown-item"><i class="bi bi-trash-fill"></i>Eliminar</a>';;
            })
            ->rawColumns(['action', 'Eliminar' , 'nombre' , 'direccion' , 'telefono' , 'url_web' , 'rating' , 'descripcion' , 'tipo_negocio_id' , 'pais_id' , 'ciudad_id' , 'barrio_id']); // Permitir HTML en estas columnas
    }
 
    public function query()
    {
          // Obtener los datos desde la columna 'data' de la tabla 'db_user'
          $query = DB::table('data_db')
            ->select(
                [
                    'id' , 
                    'nombre' , 
                    'direccion' , 
                    'telefono' , 
                    'url_web' , 
                    'rating' , 
                    'descripcion' , 
                    'tipo_negocio_id' , 
                    'pais_id' , 
                    'ciudad_id' , 
                    'barrio_id'
                ])->where('id_user_db' ,$this->user_db );
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
          
            Column::make('nombre')->title('Nombre'),
        
            Column::make('direccion')->title('Dirección'),
        
            Column::make('telefono')->title('Telefono'),
        
            Column::make('url_web')->title('URL WEB'),
        
            Column::make('rating')->title('rating'),
        
            Column::make('tipo_negocio_id')->title('tipo_negocio_id'),
            Column::make('pais_id')->title('pais_id'),
            Column::make('ciudad_id')->title('ciudad_id'),
            Column::make('barrio_id')->title('barrio_id'),
            Column::make('Eliminar')->title('Eliminar BD'),
        
          
        ];
    }
}
