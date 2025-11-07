<?php

namespace App\Services;

use App\Models\Empleado;
use PHPJasper\PHPJasper;
use Illuminate\Support\Facades\Log;

class NominaReportService
{
    public function generate($inputFile, array $options = [], $periodo)
    {
        $jasper = new PHPJasper;

        // Compilar directamente desde terminal el archivo jrxml para que funcione, solo es necesario cuando es nuevo   
        // ./vendor/geekcom/phpjasper/bin/jasperstarter/bin/jasperstarter compile "/var/www/siaaf/reports/nomina_completa.jrxml"

        $jasperPath = base_path("reports/$inputFile.jasper"); //Ubicacion de archivo jasper
        $data = json_decode(file_get_contents("/var/www/siaaf/storage/app/private/reports/nomina_{$periodo}.json"), true); // Json con datos para el reporte

        // Crear directorio de salida en caso de que no exista
        $outputDir = storage_path("app/reports/nomina/{$periodo}");
        if (!is_dir($outputDir)) mkdir($outputDir, 0775, true);

        $generated = [];

        // Recorremos el contenido del json
        foreach ($data as $id => $info) {

            // Obtenemos la informacion del empleado
            $empleado = Empleado::find($id);
            if (!$empleado) {
                Log::warning("Empleado ID {$id} no encontrado.");
                continue;
            }

            // Sanitizamos el nombre
            $nombre = "{$empleado->a_paterno} {$empleado->a_materno} {$empleado->nombre}";
            $safeName = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nombre);
            $safeName = preg_replace('/[^A-Za-z0-9 _.-]/', '', $safeName);

            $outputName = "Recibo {$periodo} {$safeName}";
            $outputPath = "{$outputDir}/{$outputName}";

            // Creamos un archivo json temporal para cada empleado
            $tempJson = storage_path("app/private/reports/temp_empleado_{$id}.json");
            $empleadoInfo = $info['empleado'] ?? [];
            if (!is_array($empleadoInfo)) {
                $empleadoInfo = [$empleadoInfo];
            }

            $empleadoJson = ['empleado' => $empleadoInfo];

            // Limpiamos el json antes de guardarlo
            if (is_array($empleadoJson)) {
                array_walk_recursive($empleadoJson, function (&$value) {
                    // Convertir "0" a integer 0
                    if ($value === "0") {
                        $value = 0;
                    }
                });
            }

            file_put_contents($tempJson, json_encode($empleadoJson, JSON_UNESCAPED_UNICODE));

            // Usamos el nuevo json para crear el reporte de cada empleado
            $options['db_connection']['data_file'] = $tempJson;

            // Creacion de reporte
            $jasper->process($jasperPath, $outputPath, $options)->execute();

            // Convertir pdf a imagen
            $pdfPath = $outputPath . '.pdf';
            $imagePath = $outputPath . '.jpg';

            $cmd = sprintf(
                'gs -dSAFER -dNOPAUSE -dBATCH -sDEVICE=jpeg -dJPEGQ=95 ' .
                    '-r300x300 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 ' .
                    '-dFirstPage=1 -dLastPage=1 -sOutputFile=%s %s',
                escapeshellarg($imagePath),
                escapeshellarg($pdfPath)
            );
            exec($cmd, $outputLines, $exitCode);

            if ($exitCode !== 0) {
                Log::error('Ghostscript conversion failed', [
                    'cmd' => $cmd,
                    'output' => $outputLines,
                    'code' => $exitCode,
                ]);
                continue;
            }

            // Borramos temp JSON
            unlink($tempJson);

            $generated[] = $imagePath;
        }

        return $generated;
    }
}
