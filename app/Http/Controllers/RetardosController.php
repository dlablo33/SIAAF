<?php

namespace App\Http\Controllers;

use App\Models\RH\Checador;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RetardosController extends Controller
{
    // Mostrar lista de retardos
    public function index($periodo)
    {
        $periodo -= 1;
        $cDate = Carbon::now(); // Inicializa Carbon para las fechas
        $cDate->setISODate(2025, $periodo); // Convertimos el periodo en una semana del año
        $start = $cDate->startOfWeek()->toDateString(); // Tomamos el primer dia de la semana
        $end = $cDate->endOfWeek()->toDateString(); // Tomamos el ultimo dia de la semana

        // Consulta de checador, se agrega tiempos de retraso y salida temprana y se agrupa por empleado
        $checador = Checador::whereBetween('date', [$start, $end])
            ->selectRaw(
                '*,
                GREATEST(0, TIMESTAMPDIFF(MINUTE, TIME("08:00:00"), TIME(check_in))) AS retraso,
                GREATEST(0, TIMESTAMPDIFF(MINUTE, TIME(check_out), TIME("18:00:00"))) AS salida_temprana'
            )
            ->get()
            ->groupBy('id_empleado');

        $empleadosList = []; // Se inicializa empleados
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes']; // Se usaran como llave

        foreach ($checador as $id_empleado => $registros) {
            $empleado = [ // Se construye el objeto empleado que vamos a pasar
                'id' => $id_empleado,
                'semana' => array_fill_keys($diasSemana, null)
            ];

            foreach ($registros as $registro) {
                $fecha = Carbon::parse($registro->date);
                $nombreDia = $diasSemana[$fecha->dayOfWeek - 1]; // Carbon: 1=Lunes, 5=Viernes

                // Se anidan los registros del dia en la semana
                $empleado['semana'][$nombreDia] = [
                    'entrada' => $registro->check_in,
                    'salida' => $registro->check_out,
                    'retraso' => $registro->retraso,
                    'salida_temprana' => $registro->salida_temprana
                ];
            }

            $empleadosList[] = $empleado;
        }

        Log::info($empleadosList);

        // Pasar el array a paginate
        $page = request()->get('page', 1);
        $perPage = 10; // Items por pagina
        $offset = ($page - 1) * $perPage;
        $empleados = new \Illuminate\Pagination\LengthAwarePaginator(
            array_slice($empleadosList, $offset, $perPage),
            count($empleadosList),
            $perPage,
            $page,
            [
                'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                'query' => request()->query()
            ]
        );

        return view('rh.retardos.index', compact('empleados'));
    }
}
