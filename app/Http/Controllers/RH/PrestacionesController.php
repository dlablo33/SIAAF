<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\Prestaciones;
use Illuminate\Http\Request;

class PrestacionesController extends Controller
{
    //
    public function index()
    {
        $prestaciones = Prestaciones::get();
        return view('rh.prestaciones.index', compact('prestaciones'));
    }

    // Crear nueva prestacion
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'string',
        ]);

        Prestaciones::create($validated  +  ['id_estatus' => 1]);

        return redirect()->back();
    }

    // Actualizar prestacion
    public function update(Request $request, $id)
    {
        $prestacion = Prestaciones::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'string',
        ]);
        $prestacion->update($validated);
        return back();
    }

    // Eliminar prestacion
    public function destroy($id)
    {
        $prestacion = Prestaciones::find($id);
        $prestacion->update(['id_estatus' => 2]);

        return redirect()->back();
    }
}
