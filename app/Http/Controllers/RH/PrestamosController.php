<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\EsquemaDeducciones;
use App\Models\RH\Prestamo;
use App\Models\RH\PrestamoHistorial;
use App\Models\RH\SolicitudPrestamo;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrestamosController extends Controller
{
    //
    public function index()
    {
        $prestamos = Prestamo::where('id_estatus', 1)->with('empleado')->get();
        $saldoTotal = 200000;
        $saldoPrestado = $prestamos->sum(
            function ($prestamo) {
                $start = Carbon::parse($prestamo->fecha_inicio);
                $end = Carbon::parse($prestamo->fecha_fin);
                $weeks = $start->diffInWeeks($end);
                return $prestamo->pago_periodo * $weeks;
            }
        );
        $saldoDisponible = $saldoTotal - $saldoPrestado;

        return view('rh.prestamos.index', compact('prestamos', 'saldoTotal', 'saldoPrestado', 'saldoDisponible'));
    }

    public function getHistorial(Request $request)
    {
        $prestamoId = $request->query('id');
        $prestamo = Prestamo::where('id', $prestamoId)->first();
        $id = $prestamo->id_empleado;

        $deduccion = EsquemaDeducciones::where('id_empleado', $id)->where('id_deducciones', 5)
            ->where(function ($q) {
                $q->whereNull('deleted_at')
                    ->orWhere('deleted_at', '>', now());
            })
            ->first();

        try {
            $cantidad = $deduccion->cantidad;

            $now = Carbon::now();
            $start = Carbon::parse($prestamo->fecha_inicio);
            $end = Carbon::parse($prestamo->fecha_fin);

            $passedDays = max(0, $start->diff($now)->days);
            $weeksPassed = floor($passedDays / 7);

            $historial = [];

            for ($date = $start->copy(); $date->lte($end) && $date->lte($now); $date->addWeek()) {
                $historial[] = [
                    'fecha' => $date->toDateString(),
                    'pago'  => $cantidad,
                ];
            }
            return response()->json($historial);
        } catch (\Throwable $th) {
        }
    }

    public function calculadora(Request $request)
    {
        try {
            $id = $request->query('id');
            $solicitud = SolicitudPrestamo::findOrFail($id);
            return view('rh.prestamos.calculadora', compact('solicitud'));
        } catch (\Throwable $th) {
            return view('rh.prestamos.calculadora');
        }
    }

    public function savePrestamo(Request $request)
    {
        $validated = $request->validate([
            'id_empleado' => 'required|numeric',
            'tipo' => 'required|string',
            'pago_periodo' => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        Prestamo::create($validated);

    }
}
