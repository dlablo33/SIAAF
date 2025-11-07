<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Services\NominaReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportesController extends Controller
{
    public function generateReporte($periodo, Request $request, NominaReportService $report)
    {

        $empleadoId = $request->query('empleado');
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

        if ($empleadoId) {
            // Regresamos el reporte de un empleado
            $empleado = Empleado::find($empleadoId);
            $nombre = "{$empleado->a_paterno} {$empleado->a_materno} {$empleado->nombre}";
            $safeName = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nombre);
            $safeName = preg_replace('/[^A-Za-z0-9 _.-]/', '', $safeName);
            $filename = "Recibo " . $periodo . " " . $safeName . ".jpg";
            
            $imgPath = "$outputDir/$filename";

            // Regresar imagen si existe
            if (file_exists($imgPath)) {
                return response()->file($imgPath, [
                    'Content-Disposition' => "attachment; filename={$filename}",
                    'Cache-Control' => 'no-cache, must-revalidate',
                ]);
            }else{
                return response(null, 204);
            }
        } elseif (!$empleadoId) {
            // Generamos los reportes de todos los empleados
            $report->generate(
                'nomina_completa',
                $options,
                $periodo
            );
        }
    }
}
