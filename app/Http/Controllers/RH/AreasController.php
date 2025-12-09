<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\Area;
use App\Models\RH\Departamento;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AreasController extends Controller
{

    public function index()
    {
        $areas = Area::where('id_estatus', 1)->get();
        return view('rh.areas.index', compact('areas'));
    }

    // Crear nueva area
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'string'
        ]);

        Area::create($validated  +  ['id_estatus' => 1]);
        Log::info($validated);
        return redirect()->back();
    }

    // Actualizar area
    public function update(Request $request, $id)
    {
        $area = Area::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'string'
        ]);
        $area->update($validated);
        return back();
    }

    // Eliminar area
    public function destroy($id)
    {
        $departamentos = Departamento::where('id_area', $id)->where('id_estatus', 1)->get();
        Log::info($departamentos);
        if ($departamentos->isNotEmpty()) {
            return response()->json([
                'message' => 'Esta area tiene departamentos asignados. Por favor, deshabilitalos antes de continuar.'
            ], 202);
        } else {
            $area = Area::findOrFail($id);
            $area->update(['id_estatus' => 2]);
            $area->delete();

            return response('Succes', 200);
        }
    }
}
