<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Services\NominaReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ReportesController extends Controller
{
    public function generateReporte($periodo, Request $request, NominaReportService $report)
    {
        $outputDir = storage_path("app/reports/nomina/$periodo");

        // Crear folder si no existe
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        // Pasamos informacion de formato y coneccion a base de datos
        $options = [
            'format' => ['pdf'],
            'db_connection' => [
                'driver' => 'json',
                'data_file' => "/var/www/siaaf/storage/app/private/reports/nomina_$periodo.json",
                'json_query' => 'empleado'
            ]
        ];

        $report->generate(
            'nomina_completa',
            $options,
            $periodo
        );
    }

    // Revisamos que exista un reporte especifico
    public function checkReporte($periodo, Request $request)
    {
        $empleadoId = $request->query('empleado');

        if (!$empleadoId) {
            return response('No se envió el parámetro empleado.', 400);
        }

        // Incluimos empleados dados de baja
        $empleado = Empleado::withTrashed()->find($empleadoId);

        if (!$empleado) {
            return response('El empleado no existe.', 404);
        }

        $outputDir = storage_path("app/reports/nomina/$periodo");

        $nombre = "{$empleado->a_paterno} {$empleado->a_materno} {$empleado->nombre}";
        $safeName = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nombre);
        $safeName = preg_replace('/[^A-Za-z0-9 _.-]/', '', $safeName);
        $filename = "Recibo " . $periodo . " " . $safeName . ".jpg";

        $imgPath = "$outputDir/$filename";

        $exists = file_exists($imgPath);

        return response()->json([
            'exists' => $exists,
            'path' => $exists ? $imgPath : null
        ], 200);
    }

    public function checkReportes($periodo)
    {
        $path = storage_path("app/reports/nomina/$periodo");

        // Regresamos si el folder no existe
        if (!is_dir($path)) {
            return response()->json([
                'exists' => false
            ], 200);
        }

        // Checamos que haya algun reporte
        $files = File::files($path);

        return response()->json([
            'exists' => !empty($files)
        ], 200);
    }



    public function getReporte($periodo, Request $request)
    {
        $imgPath = $request->input('path');

        // Checamos que traiga el path y que sea un string
        if (!is_string($imgPath) || empty($imgPath)) {
            return response()->json([
                'error' => 'No se recibió la ruta del archivo.'
            ], 400);
        }

        // Tomamos donde se guardan los repotes
        $baseDir = storage_path("app/reports/nomina/$periodo");

        // Security Check - revisamos que concuerde el path con el directorio
        if (!str_starts_with($imgPath, $baseDir)) {
            return response()->json([
                'error' => 'Ruta inválida.'
            ], 403);
        }

        if (!file_exists($imgPath)) {
            return response()->json([
                'error' => 'El archivo no existe.'
            ], 404);
        }

        $filename = basename($imgPath);

        return response()->file($imgPath, [
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }
}
