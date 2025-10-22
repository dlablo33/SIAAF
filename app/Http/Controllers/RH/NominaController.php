<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NominaController extends Controller
{
    // Mostrar lista de empleados con nomina
    public function index()
    {
        $periodo = 22;
        return view('rh.nomina.index')->with('periodo',$periodo);
    }
}
