<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\Prestamo;
use App\Models\RH\PrestamoHistorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrestamosController extends Controller
{
    //
    public function index()
    {
        $prestamos = Prestamo::where('id_estatus', 1)->with('empleado')->get();
        return view('rh.prestamos.index', compact('prestamos'));        
    }

    public function getHistorial(Request $request){
        $prestamoId = $request->query('id');
        $historial = PrestamoHistorial::where('id_prestamo',$prestamoId)->get();

        return response()->json($historial);
    }
}
