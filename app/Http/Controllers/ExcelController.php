<?php

namespace App\Http\Controllers;

use App\Imports\ChecadorImport;
use App\Imports\DataImport;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    // Importacion para el modelo checador/tabla retardos
    public function checadorImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048' // Max 2MB
        ]);

        $file = $request->file('file');
        $import = new ChecadorImport();

        try {
            Excel::import($import, $file);
            if (!empty($import->errors)) {
                return back()->withErrors($import->errors);
            }

            return  back()->with('success', 'File imported successfully!');

        } catch (QueryException $e) {
            // ✅ Check for foreign key violation
            if ($e->getCode() === '23000') {
                return back()->with(
                    'error',
                    'Algunos registros no pudieron importarse porque el empleado asignado no existe en la base de datos. ' .
                        'Verifica que todos los IDs de empleados en el archivo estén registrados antes de importar.'
                );
            }

            // ✅ For any other DB error
            Log::error($e);
            return back()->with('error', 'Ocurrió un error en la base de datos: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', 'Error inesperado al importar el archivo. Revisa el formato y los datos.');
        }
    }
}
