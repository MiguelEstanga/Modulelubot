<?php 
namespace Modules\Lubot\DataTables;

use App\DataTables\BaseDataTable;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class CampanaTable extends BaseDataTable
{
    public $idCompanie;

    public function objetivo_lubot($id)
    {
        $objetivo = DB::table('objetivos_lubot')->where('id' , $id)->first();
        return $objetivo->objetivos;
    }
    public function ConId($id)
    {
        $this->idCompanie = $id;
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
                
                        $action .='<a href="' . route('campanas.eliminar', $row->id) . '" class="dropdown-item"><i class="bi bi-trash3"></i> Eliminar</a>';
                $action .= '<a href="' . route('campana_segmentes', $row->id) . '" class="dropdown-item"><i class="fa fa-eye mr-2"></i>' . __('app.view') . '</a>';
                $action .= '<a  onclick="edit('.$row->id.')" class="dropdown-item"><i class="fa fa-eye mr-2"></i>' . 'Propms' . '</a>';
                $action .= '</div>
                    </div>
                </div>';

                
                return $action;
            })
            
            ->addColumn('nombre', function ($row) {
                return $row->nombre;
            }) 
            
            ->addColumn('como_me_llamo', function ($row) {
                return $row->como_me_llamo;
            })    

            ->addColumn('sobre_la_empresa', function ($row) {
                return $row->spbre_la_empresa;
            }) 
            
            ->addColumn('temporalidad', function ($row) {
                return $row->temporalidad;
            })   

            ->addColumn('credito', function ($row) {
                return $row->credito;
            })   

            ->addColumn('objetivo_de_lubot', function ($row) {
                return  $this->objetivo_lubot($row->objetivo_de_lubot) ;
            })  
            
            ->addColumn('estado', function ($row) {
                return  $row->encendido ;
            })  
            ->rawColumns(['action'  ]); // Permitir HTML en estas columnas
            
    }
 
    public function query()
    {
        $query = DB::table('campanas' , $this->idCompanie)
            ->select(['id', 'nombre' , 'como_me_llamo' ,'spbre_la_empresa' , 'temporalidad' , 'credito' , 'objetivo_de_lubot' , 'encendido'])
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
            Column::make('como_me_llamo')->title('Como me llamo'),
            Column::make('sobre_la_empresa')->title('Sobre la empresa'),
            Column::make('temporalidad')->title('temporalidad'),
            Column::make('credito')->title('credito'),
            Column::make('objetivo_de_lubot')->title('Objetivo de lubot'),
            Column::make('estado')->title('Estado'),
            Column::computed('action')->exportable(false)->printable(false)->orderable(false)->searchable(false)->title(__('app.action'))
                ->width(150)->addClass('text-right pr-20'),
          
        ];
    }
}
