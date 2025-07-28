<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\Area;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AreasController extends Controller
{

    public function index()
    {
        $areas = Area::where('id_estatus', 1)->paginate(10);
        return view('rh.areas.index', compact('areas'));
    }

    // Mostrar formulario de creación
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
        $area = Area::find($id);
        $area->update(['id_estatus' => 2]);

        return redirect()->back();
    }
}
