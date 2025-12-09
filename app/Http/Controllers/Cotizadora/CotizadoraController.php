<?php

namespace App\Http\Controllers\Cotizadora;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;

class CotizadoraController extends Controller
{
    /**
     * Mostrar el formulario de cotización
     */
    public function index()
    {
        return view('cotizadora.index');
    }

    /**
     * Guardar la cotización (pública - sin autenticación requerida)
     */
public function guardar(Request $request)
    {
        Log::info('Datos recibidos en cotizadora:', $request->all());

        // Validación básica
        $validated = $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'correo_cliente' => 'required|email',
            'telefono_cliente' => 'nullable|string',
            'tamano_empresa' => 'required|string',
            'empleados' => 'required|integer',
            'servicios' => 'required|array',
            'total' => 'required|numeric',
            'recomendacion' => 'nullable|string'
        ]);

        try {
            // Generar ID de cotización
            $cotizacionId = 'COT-' . date('YmdHis') . rand(100, 999);
            
            // Aquí puedes guardar en base de datos
            // Por ahora solo retornamos éxito
            
            return response()->json([
                'success' => true,
                'message' => 'Cotización guardada correctamente',
                'cotizacion_id' => $cotizacionId,
                'data' => $validated
            ]);

        } catch (\Exception $e) {
            Log::error('Error en cotizadora: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la cotización'
            ], 500);
        }
    }


    /**
     * Guardar en archivo como backup si falla la BD
     */
    private function guardarEnBackup($data)
    {
        try {
            $backupData = [
                'timestamp' => now()->toDateTimeString(),
                'data' => $data,
                'ip' => request()->ip()
            ];
            
            $backupPath = storage_path('logs/cotizaciones_backup.log');
            file_put_contents($backupPath, json_encode($backupData) . PHP_EOL, FILE_APPEND | LOCK_EX);
            
            Log::info('📂 Cotización guardada en archivo de backup');
        } catch (\Exception $e) {
            Log::error('Error al guardar en backup: ' . $e->getMessage());
        }
    }

    /*
    private function enviarEmailConfirmacion($cotizacion)
    {
        // Implementar envío de email aquí
        Mail::send('emails.cotizacion', ['cotizacion' => $cotizacion], function ($message) use ($cotizacion) {
            $message->to($cotizacion->correo_cliente)
                    ->subject('Confirmación de Cotización - AAF Solutions');
        });
    } */
}