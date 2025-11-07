<?php

namespace App\Imports;

use App\Models\RH\Checador;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ChecadorImport extends DefaultValueBinder implements ToModel, WithStartRow
{

    public $errors = [];

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        //  Log::debug('Processing row:', $row);

        // Skip fecha si es null o esta vacio
        if (empty($row[3])) {
            return null;
        }

        try {
            return new Checador([ // Guarda el modelo en la bd
                'id_empleado' => $this->parseEmployeeId($row[0]),
                'date'        => $this->parseDate($row[3]),
                'check_in'    => $this->parseTime($row[7]),
                'check_out'   => $this->parseTime($row[8]),
            ]);
            
        } catch (QueryException $e) {
            // foreign key / DB constraint
            if ($e->getCode() === '23000') {
                $this->errors[] = "Fila desconocida: el empleado con ID {$row[0]} no existe en la base de datos.";
            } else {
                $this->errors[] = "Error de base de datos al procesar la fila (empleado {$row[0]}): " . $e->getMessage();
            }
            Log::error("DB error on row: " . json_encode($row) . " - " . $e->getMessage());
            return null;
        } catch (\Throwable $e) {
            // anything else (bad date, invalid ID, etc.)
            $this->errors[] = "Error en fila con empleado {$row[0]}: " . $e->getMessage();
            Log::error("Failed to process row: " . json_encode($row) . " - " . $e->getMessage());
            return null;
        }
    }

    // Obtener fecha
    protected function parseDate($value): string
    {
        //Convertir fecha de excel a carbon
        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($value))
                ->format('Y-m-d');
        }

        // Intentar distintos formatos de fecha
        $formats = ['d/m/Y', 'm/d/Y', 'Y-m-d'];
        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $value)->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }
        throw new \RuntimeException("Unparseable date format: {$value}");
    }

    // Obtener hora de entrada y salida
    protected function parseTime($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        // Las horas de excel vienen en fraccion del dia
        if (is_numeric($value)) {
            $seconds = round($value * 86400); // 86400 segundos en u dia
            return gmdate('H:i:s', $seconds);
        }

        // Log::warning("Unparseable time format: {$value}");
        return null;
    }

    // Obtener id del empleado
    protected function parseEmployeeId($value): int
    {
        // Verifica que contenga digitos
        if (is_string($value) && preg_match('/\d+/', $value, $matches)) {
            return (int)$matches[0]; // Convierte le string a int
        }

        throw new \RuntimeException("Invalid employee ID format: {$value}");
    }
}
