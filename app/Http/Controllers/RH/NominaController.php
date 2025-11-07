<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\RH\Deducciones;
use App\Models\RH\EsquemaDeducciones;
use App\Models\RH\EsquemaPrestaciones;
use App\Models\RH\Prestaciones;
use App\Services\NominaJsonBuilderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NominaController extends Controller
{
    // Mostrar lista de empleados con nomina
    public function index($periodo)
    {
        Carbon::setLocale('es');
        $periodo -= 1;
        $cDate = Carbon::now(); // Inicializa Carbon para las fechas
        $cDate->setISODate(2025, $periodo); // Convertimos el periodo en una semana del año
        $start = $cDate->startOfWeek()->toDateString(); // Tomamos el primer dia de la semana
        $end = $cDate->endOfWeek()->toDateString();
        $periodoOg = $periodo + 1;

        // Fechas en formato para mostrar
        $fechaPeriodo = "{$cDate->copy()->startOfWeek()->isoFormat('D')} - {$cDate->copy()->endOfWeek()->isoFormat('D MMMM Y')}";
        $fechaNomina = "{$cDate->copy()->addDays(4)->isoFormat('dddd, D MMMM Y')}";

        // Queries para obtener las prestaciones y deducciones mas nuevas antes del periodo
        $ultimaPrestacion = EsquemaPrestaciones::select(
            DB::raw('MAX(id) as max_id'),
            'id_empleado',
            'id_prestaciones',
            'tipo'
        )
            ->where('created_at', '<', $start)
            ->groupBy('id_empleado', 'id_prestaciones', 'tipo');

        $ultimaDeduccion = EsquemaDeducciones::select(
            DB::raw('MAX(id) as max_id'),
            'id_empleado',
            'id_deducciones',
            'tipo'
        )
            ->where('created_at', '<', $start)
            ->groupBy('id_empleado', 'id_deducciones', 'tipo');

        // Obtenemos los esquemas del modelo que se va a usar para el periodo
        $prestRaw = EsquemaPrestaciones::with('prestacion')
            ->joinSub(
                $ultimaPrestacion,
                'ultima',
                fn($join) =>
                $join->on('esquema_prestaciones.id', '=', 'ultima.max_id')
            )
            ->get();

        $deducRaw = EsquemaDeducciones::with('deduccion')
            ->joinSub(
                $ultimaDeduccion,
                'ultima',
                fn($join) =>
                $join->on('esquema_deducciones.id', '=', 'ultima.max_id')
            )
            ->get();

        // Se agrupa por empleado y se unen los id en una sola lista
        $prestByEmp = $prestRaw->groupBy('id_empleado');
        $deducByEmp = $deducRaw->groupBy('id_empleado');
        $allIds = $prestByEmp->keys()->merge($deducByEmp->keys())->unique();

        // Se crea una colleccion con toda la informacion
        $empleados = collect();
        foreach ($allIds as $id) {
            $empleadoModel = Empleado::select('id', 'nombre', 'a_paterno', 'a_materno')->find($id);

            $prestacionesPorTipo = $prestByEmp->get($id)?->groupBy('tipo') ?? collect();
            $deduccionesPorTipo  = $deducByEmp->get($id)?->groupBy('tipo') ?? collect();

            $empleados->put($id, [
                'empleado' => $empleadoModel,
                'prestaciones' => [
                    'FISCAL' => $prestacionesPorTipo->get('FISCAL', collect())->keyBy('id_prestaciones'),
                    'COMPLEMENTO' => $prestacionesPorTipo->get('COMPLEMENTO', collect())->keyBy('id_prestaciones'),
                ],
                'deducciones' => [
                    'FISCAL' => $deduccionesPorTipo->get('FISCAL', collect())->keyBy('id_deducciones'),
                    'COMPLEMENTO' => $deduccionesPorTipo->get('COMPLEMENTO', collect())->keyBy('id_deducciones'),
                ],
            ]);
        }

        // Obtenermos la lista de prestaciones y deducciones para los headers
        $prestaciones = Prestaciones::where('created_at', '<', $start)
            ->where(function ($q) use ($start) {
                $q->whereNull('deleted_at')
                    ->orWhere('deleted_at', '>', $start);
            })
            ->get();

        $deducciones = Deducciones::where('created_at', '<', $start)
            ->where(function ($q) use ($start) {
                $q->whereNull('deleted_at')
                    ->orWhere('deleted_at', '>', $start);
            })
            ->get();

        // Creamos dispersion
        $dispersion = [
            'FISCAL' => collect(),
            'COMPLEMENTO' => collect(),
        ];

        foreach ($empleados as $id => $data) {
            foreach (['FISCAL', 'COMPLEMENTO'] as $tipo) {
                // Sumar prestaciones y deducciones de ese tipo
                $totalPrest = $data['prestaciones'][$tipo]->sum(fn($p) => $p->cantidad ?? 0);
                $totalDeduc = $data['deducciones'][$tipo]->sum(fn($d) => $d->cantidad ?? 0);

                // Total final = prestaciones - deducciones
                $total = $totalPrest - $totalDeduc;

                $dispersion[$tipo]->put($id, [
                    'empleado' => $data['empleado'],
                    'total' => $totalPrest,
                ]);
            }
        }

        $periodoOg = $periodo + 1;


        $json = new NominaJsonBuilderService();
        $json->build($empleados, $periodoOg, $fechaPeriodo, $fechaNomina);



        return view('rh.nomina.index', compact('periodoOg', 'fechaPeriodo', 'fechaNomina', 'prestaciones', 'empleados', 'deducciones', 'dispersion'));
    }
}
