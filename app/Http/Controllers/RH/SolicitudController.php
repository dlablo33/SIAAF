<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\EmpleadoVacaciones;
use App\Models\RH\EsquemaPrestaciones;
use App\Models\RH\PermisoTipo;
use App\Models\RH\SolicitudPermiso;
use App\Models\RH\SolicitudPrestamo;
use App\Models\RH\SolicitudVacaciones;
use App\Models\RH\Sugerencias;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {

        $estadoRequest = $request->input('estado', 'all');
        $tipoRequest   = $request->input('tipo', 'all');

        $solicitudes = collect([
            ['class' => SolicitudPrestamo::class, 'tipo' => 'Préstamo', 'relations' => ['estatus', 'empleado']],
            ['class' => SolicitudPermiso::class,  'tipo' => 'Permiso',  'relations' => ['estatus', 'empleado']],
            ['class' => SolicitudVacaciones::class, 'tipo' => 'Vacaciones', 'relations' => ['estatus', 'empleadoVacaciones.empleado']],
            ['class' => Sugerencias::class,  'tipo' => 'Sugerencias',  'relations' => ['empleado']],
        ])->flatMap(
            fn($cfg) =>
            $cfg['class']::with($cfg['relations'])->get()
                ->map(fn($i) => $i->setAttribute('tipo', $cfg['tipo']))
        )->sortByDesc('created_at')->values();

        if ($tipoRequest && $tipoRequest !== 'all') {
            $solicitudes = $solicitudes->where('tipo', $tipoRequest);
        }

        if ($estadoRequest && $estadoRequest !== 'all') {
            $solicitudes = $solicitudes->where('id_estatus', $estadoRequest);
        }

        $conteos = $solicitudes
            ->filter(fn($s) => $s->id_estatus == 3)
            ->groupBy('tipo')
            ->map
            ->count();

        $estatusActivo = 1;
        $prestamoTotales = ['cantidadPrestada' => $solicitudes
            ->where('tipo', 'Préstamo')
            ->where('id_estatus', $estatusActivo)
            ->sum('monto_pedido'), 'cantidadDisponible' => 200000];

        if ($request->ajax()) {
            return response()->json($solicitudes);
        }

        return view('rh.solicitudes.index', compact('solicitudes', 'conteos', 'prestamoTotales'));
    }

    public function getSolicitud(Request $request)
    {
        $tipo = $request->input('tipo');
        $id = $request->input('id');
        switch ($tipo) {
            case 'Permiso':
                $data = SolicitudPermiso::with(['empleado', 'estatus', 'tipo'])->findOrFail($id);
                break;

            case 'Préstamo':
                $userId = Auth::user()->empleado->id;
                $montoLimite = (EsquemaPrestaciones::where('id_empleado', $userId)->where('id_estatus', 1)->sum('cantidad')) * 3;
                $cantidadPrestada = SolicitudPrestamo::where('id_estatus', 4)->sum('monto_pedido');

                $data = SolicitudPrestamo::with(['empleado', 'estatus'])->findOrFail($id);

                $data->monto_limite = $montoLimite;
                $data->cantidad_prestada = $cantidadPrestada;
                $data->cantidad_disponible = 200000 - $cantidadPrestada;

                break;

            case 'Vacaciones':
                $data = SolicitudVacaciones::with(['empleadoVacaciones', 'empleadoVacaciones.empleado', 'estatus'])->findOrFail($id);
                break;

            case 'Sugerencias':
                $data = Sugerencias::with('empleado')->findOrFail($id);
                break;

            default:
                return response()->json(['error' => 'Tipo no válido'], 400);
        }

        return response()->json($data);
    }

    public function updateSolicitud(Request $request)
    {
        $solicitud = $request->input('solicitud');
        $tipo = $request->input('tipo');
        $id = $request->input('id');
        $diasSolicitados = $request->input('dias_solicitados');
        $comentario = $request->input('comentario');
        $userId = Auth::user()->empleado->id;



        Log::info("$solicitud - $tipo - $id - $diasSolicitados - $userId");

        // Listas de modelos
        $lista = [
            'Vacaciones'  => SolicitudVacaciones::class,
            'Permiso'     => SolicitudPermiso::class,
            'Préstamo'    => SolicitudPrestamo::class,
        ];

        if (!isset($lista[$solicitud])) {
            return response()->json(['error' => 'Tipo de solicitud inválido'], 400);
        }

        $modelSolicitud = $lista[$solicitud];
        $model = $modelSolicitud::findOrFail($id);

        // Ajuste de Permisos
        if ($solicitud === 'Permiso' && $model->id_tipo === 4) {
            $resultado = $this->ajustarPermisos($model->id_estatus, $tipo, $userId, 1);
        } else if ($solicitud === 'Vacaciones') {
            $resultado = $this->ajustarPermisos($model->id_estatus, $tipo, $userId, $diasSolicitados);
        }

        // Manejamos los mensajes, en caso de que haya
        if (!empty($comentario)) {
            $model->comentarios = $comentario;
        }

        if ($resultado instanceof Response && $resultado->getStatusCode() === 422) {
            return $resultado; // STOP EVERYTHING
        }

        // Cambiamos el estatus dependiendo de la accion
        if ($tipo === 'Rechazar') {
            $model->id_estatus = 5;
        } else if ($tipo === 'Aceptar') {
            $model->id_estatus = 4;
        }

        $model->save();
        return response('Solicitud actualizada correctamente', 200);
    }

    public function vacaciones()
    {
        $user = Auth::user();
        $prima = 0.25;

        $vacaciones = EmpleadoVacaciones::where('id_empleado', $user->empleado->id)->first();
        $vacacionesDisponibles =  $vacaciones->vacaciones_disponibles;
        $vacacionesRestantes =  $vacaciones->vacaciones_restantes;
        return view('rh.solicitudes.solicitud.solicitudVacaciones', compact('user', 'vacacionesDisponibles', 'vacacionesRestantes', 'prima'));
    }

    public function saveVacaciones(Request $request)
    {
        $user = Auth::user()->empleado->id;

        $validated = $request->validate([
            'concepto' => 'required|string',
            'fecha_inicio'  => 'required|date',
            'fecha_final'     => 'required|date',
            'prima' => 'required|numeric'
        ]);
        $empleadoVacaciones = EmpleadoVacaciones::where('id_empleado', $user)->first();
        $validated['id_empleado_vacaciones'] = $empleadoVacaciones->id;
        $validated['id_estatus'] = 3;

        SolicitudVacaciones::create($validated);

        return back()->with('Proceso realizado correctamete.', 'Vacaciones registradas.');
    }

    public function permiso()
    {
        $user = Auth::user();
        $tipoPermiso = PermisoTipo::where('id_estatus', 1)->get();
        return view('rh.solicitudes.solicitud.solicitudPermiso', compact('user', 'tipoPermiso'));
    }

    public function savePermiso(Request $request)
    {
        $userId = Auth::user()->empleado->id;

        $validated = $request->validate([
            'fecha' => 'required|string',
            'id_tipo' => 'required|string',
            'tiempo' => 'nullable|string',
            'razon' => 'required|string'
        ]);

        if ($validated['id_tipo'] == 1) { // Retardo
            $reported = Carbon::parse($validated['tiempo']);
            $limit    = Carbon::createFromTime(7, 30);
            $minutesLate = $limit->diffInMinutes($reported);
            $validated['tiempo'] = $minutesLate;
        } else if ($validated['id_tipo'] == 2) { // Home Office
            Log::info('home office');
            $validated['tiempo'] = 0;
        } else if ($validated['id_tipo'] == 3) { // Dia Parcial
            $validated['tiempo'] = 270;
        } else if ($validated['id_tipo'] == 4) { // Dia Completo
            $validated['tiempo'] = 0;
        }
        $validated['id_empleado'] = $userId;
        $validated['id_estatus'] = 3;

        SolicitudPermiso::create($validated);
    }

    public function prestamo()
    {
        $user = Auth::user();
        return view('rh.solicitudes.solicitud.solicitudPrestamo', compact('user'));
    }

    public function savePrestamo(Request $request)
    {
        $userId = Auth::user()->empleado->id;
        $montoLimite = (EsquemaPrestaciones::where('id_empleado', $userId)->where('id_estatus', 1)->sum('cantidad')) * 3;

        $validated = $request->validate([
            'fecha' => 'required|string',
            'monto_pedido' => 'required|integer'
        ]);
        $validated['id_empleado'] = $userId;
        $validated['id_estatus'] = 3;

        if ($validated['monto_pedido'] > $montoLimite) {
            return response('Su solicitud no se pudo procesar. <br> Acuda directamente a RH.', 202);
        }
        SolicitudPrestamo::create($validated);
        return response('Prestamo registrado', 200);
    }

    private function ajustarPermisos($oldStatus, $newAction, $empleadoId, $dias)
    {
        $newStatus = $newAction === 'Aceptar' ? 4 : 5;

        // ACEPTAR
        if ($newStatus === 4) {
            if ($oldStatus == 3 || $oldStatus == 5) {
                return $this->ajustarDiasVacaciones($empleadoId, $dias);
            }
            return response("Proceso realizado correctamete.", 202);
        }

        // RECHAZAR
        if ($newStatus === 5) {
            if ($oldStatus == 4) {
                return $this->ajustarDiasVacaciones($empleadoId, -$dias);
            }
            return response("Proceso realizado correctamete.", 202);
        }
    }


    private function ajustarDiasVacaciones($empleadoId, $diasUsados)
    {
        $empleadoVacaciones = EmpleadoVacaciones::where('id_empleado', $empleadoId)->first();

        if (!$empleadoVacaciones) {
            return response('No se encontró registro de vacaciones.', 422);
        }

        if ($diasUsados > 0) {
            // Restamos Dias
            if ($empleadoVacaciones->vacaciones_restantes < $diasUsados) {
                return response('No tiene suficientes días de vacaciones restantes.', 422);
            }
            $empleadoVacaciones->vacaciones_restantes -= $diasUsados;
        }

        if ($diasUsados < 0) {
            // Sumamos Dias
            $empleadoVacaciones->vacaciones_restantes -= $diasUsados;
        }

        $empleadoVacaciones->save();
        return response("Proceso realizado correctamete.", 202);
    }
}
