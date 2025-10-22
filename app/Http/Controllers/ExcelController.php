<?php

namespace App\Http\Controllers;

use App\Imports\ChecadorImport;
use App\Imports\DataImport;
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

        try {
            Excel::import(new ChecadorImport, $file);
            return  back()->with('success', 'File imported successfully!');
        } catch (\Exception $e) {
            Log::info($e);
            return back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }
}
