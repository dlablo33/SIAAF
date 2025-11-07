<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\Checador;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RetardosController extends Controller
{
    // Mostrar lista de retardos
    public function index($periodo)
    {
        Carbon::setLocale('es');
        $periodo -= 1;
        $cDate = Carbon::now(); // Inicializa Carbon para las fechas
        $cDate->setISODate(2025, $periodo); // Convertimos el periodo en una semana del año
        $start = $cDate->startOfWeek()->toDateString(); // Tomamos el primer dia de la semana
        $end = $cDate->endOfWeek()->toDateString(); // Tomamos el ultimo dia de la semana

        // Consulta de checador, se agrega tiempos de retraso y salida temprana y se agrupa por empleado
        $checador = Checador::with('empleado')->whereBetween('date', [$start, $end])
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

            // Se agregan los nombres y apellidos vinculados al id
            if (count($registros) > 0 && isset($registros[0]->empleado)) {
                $empData = $registros[0]->empleado;
                $empleado['nombre'] = $empData->nombre;
                $empleado['apellidos'] = $empData->a_paterno . ' ' . $empData->a_materno;
            }

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

        // Array con dias de la semana y fechas para header
        $fechaDia = [];
        for ($i = 1; $i <= 5; $i++) {
            $dayDate = $cDate->copy()->startOfWeek()->addDays($i - 1);
            $fechaDia[] = [
                'nombre' => ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'][$i - 1],
                'fecha' => $dayDate->format('d/m')
            ];
        }

        // Pasar el array a paginate
        $page = request()->get('page', 1);
        $perPage = 10; // Items por pagina
        $offset = ($page - 1) * $perPage;
        $empleados = $empleadosList;

        // Regresamos al periodo original y lo pasamos a la vista para poder seleccionarlo
        $periodoOg = $periodo + 1;
        // Si no hay registros del checador lo pasasmo vacio
        $empleados = empty($checador) ? null : $empleados;

        return view('rh.retardos.index', compact('empleados', 'fechaDia', 'periodoOg'));
    }
}
