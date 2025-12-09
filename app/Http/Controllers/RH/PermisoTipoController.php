<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\PermisoTipo;
use Illuminate\Http\Request;

class PermisoTipoController extends Controller
{
    //
    public function index()
    {
        $permisoTipo = PermisoTipo::get();
        return view('rh.permisoTipo.index', compact('permisoTipo'));
    }

    // Crear nuevo empresa
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'string',
        ]);

        PermisoTipo::create($validated  +  ['id_estatus' => 1]);

        return redirect()->back();
    }

    // Actualizar empresa
    public function update(Request $request, $id)
    {
        $empresa = PermisoTipo::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'string',
        ]);
        $empresa->update($validated);
        return back();
    }

    // Eliminar empresa
    public function destroy($id)
    {
        $empresa = PermisoTipo::find($id);
        $empresa->update(['id_estatus' => 2]);

        return redirect()->back();
    }
}
