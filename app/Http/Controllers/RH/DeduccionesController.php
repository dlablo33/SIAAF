<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\Deducciones;
use Illuminate\Http\Request;

class DeduccionesController extends Controller
{
    //
    public function index()
    {
        $deducciones = Deducciones::paginate(10);
        return view('rh.deducciones.index', compact('deducciones'));
    }

    // Crear nueva deduccion
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'string',
        ]);

        Deducciones::create($validated  +  ['id_estatus' => 1]);

        return redirect()->back();
    }

    // Actualizar deduccion
    public function update(Request $request, $id)
    {
        $deduccion = Deducciones::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'string',
        ]);
        $deduccion->update($validated);
        return back();
    }

    // Eliminar deduccion
    public function destroy($id)
    {
        $deduccion = Deducciones::find($id);
        $deduccion->update(['id_estatus' => 2]);

        return redirect()->back();
    }
}
