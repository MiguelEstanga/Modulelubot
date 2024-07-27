<?php 
namespace Modules\Lubot\DataTables;

use App\DataTables\BaseDataTable;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class SegmentosTable extends BaseDataTable
{
    protected $id;

    public function withId($id)
    {
        $this->id = $id;
       // return $this;
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
            ->addColumn('Pais', function ($row) {
                return $row->pais;
            })
            ->addColumn('Ciudad', function ($row) {
                return $row->ciudad;
            })
            ->addColumn('Barrio', function ($row) {
                return $row->barrio;
            })
            ->addColumn('Segmento', function ($row) {
                return $row->segmento;
            });
            
            //->rawColumns(['action', 'ver_segmentos' , 'activate_campaigns']); // Permitir HTML en estas columnas
            
    }

    public function query()
    {
        $query = DB::table('segmentos')
            ->select(['id', 'barrio', 'pais', 'segmento' , 'ciudad' ])
            ->where('id_campanas' , $this->id);
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
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    protected function getColumns()
    {
        return [
            Column::make('id')->title(__('app.id'))->visible(false),
            Column::make('Pais')->title('Pais'),
            Column::make('Ciudad')->title('Ciudads'),
            Column::make('Barrio')->title('Barrios'),
            Column::make('Segmento')->title('Segmentos'),
            //Column::make('ver_segmentos')->title('Segmentos'),
           // Column::computed('action')->exportable(false)->printable(false)->orderable(false)->searchable(false)->title(__('app.action'))
             //   ->width(150)->addClass('text-right pr-20'),
          
        ];
    }
}
