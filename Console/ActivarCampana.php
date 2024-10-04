<?php

namespace Modules\Lubot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\DB;
use Modules\Lubot\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Lubot\Http\Controllers\CampanasController;
use Exception;
class ActivarCampana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'lubot_campanas_encendidas_corn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reactiva las campanas activas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        date_default_timezone_set('America/Bogota');

        $schedules = DB::table('campaign_schedules')
            ->where('estado', 1)
            ->where('next_run_at', '<=', now())->get();
        $contador = 0;
        foreach ($schedules as $schedule) {
            $this->notifyViaApi($schedule->campaign_id, $schedule->companie_id);
            DB::table('campaign_schedules')->where('id', $schedule->id)
                ->update(['next_run_at' => $this->calculateNextRun($schedule)]);
        }
        $json = json_encode($schedules);
        $hora = now();
        $this->info("numero $contador");
        $this->info("segmentos ejecutados $contador");
    }

    protected function calculateNextRun($schedule)
    {
        $nextRun = now();
        switch ($schedule->frequency_unit) {
            case 'minutes':
                $nextRun->addMinutes($schedule->frequency_number);
                break;
            case 'hours':
                $nextRun->addHours($schedule->frequency_number);
                break;
            case 'days':
                $nextRun->addDays($schedule->frequency_number);
                break;
            case 'weeks':
                $nextRun->addWeeks($schedule->frequency_number);
                break;
        }
        return $nextRun;
    }

    private function notifyViaApi($companie_id, $campana_id)
    {
        // calculamos la prxima ejecucion del promp
        CampanasController::actualizarAsignacionSegmentos($campana_id);

        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->get(HelperController::endpoiny('activar_ejecutable_ws') ."/$companie_id/{$campana_id}/{$companie_id}");

            Http::withHeaders(['Accept' => 'application/json'])
                ->get(HelperController::endpoiny('activar_ejecutable_ryc') . "/$companie_id/{$campana_id}/{$companie_id}");
        } catch (Exception  $e) {
            $response = $e;
            Log::info("error en el crom " ,$response );
        }

        Log::info("Notificación enviada correctamente para la campaña ID: ");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            //  ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
