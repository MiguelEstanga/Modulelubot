<?php 
namespace Modules\Lubot\DataTables;

use App\DataTables\BaseDataTable;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class CampanaTable extends BaseDataTable
{
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
                
                        $action .='<a href="' . route('campanas.eliminar', $row->id) . '" class="dropdown-item"><i class="bi bi-trash3"></i> Eliminar</a>';
                $action .= '<a href="' . route('campana_segmentes', $row->id) . '" class="dropdown-item"><i class="fa fa-eye mr-2"></i>' . __('app.view') . '</a>';
                $action .= '</div>
                    </div>
                </div>';

                
                return $action;
            })
            ->addColumn('responder_con_ia', function ($row) {
                return $row->responder_con_ia ? __('Si') : __('No');
            })
            ->addColumn('campanas_activa', function ($row) {
                return $row->campanas_activa ? __('Active') : __('Inactive');
            })
            ->addColumn('nombre', function ($row) {
                return $row->nombre;
            })
            ->addColumn('activate_campaigns', function ($row) {
                $checked = $row->campanas_activa ? 'checked' : '';
                return '<input type="checkbox"  onClick="estado(this)" class=".activar_estado" id="' . $row->id . '" ' . $checked . '>';
            })
            
            ->rawColumns(['action' , 'activate_campaigns' , ]); // Permitir HTML en estas columnas
            
    }
 
    public function query()
    {
        $query = DB::table('campanas')
            ->select(['id', 'nombre', 'responder_con_ia', 'campanas_activa' ])
            ;
        return $query;
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('campaigns-table')
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
            Column::make('nombre')->title('Nombre'),
            Column::make('responder_con_ia')->title('Responder con IA'),
            Column::make('campanas_activa')->title('Estado'),
            Column::make('activate_campaigns')->title('Activar'),
           
            
            Column::computed('action')->exportable(false)->printable(false)->orderable(false)->searchable(false)->title(__('app.action'))
                ->width(150)->addClass('text-right pr-20'),
          
        ];
    }
}
