<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\Departamento;
use App\Models\RH\Puesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PuestosController extends Controller
{
    //
    public function index()
    {
        $puestos = Puesto::with('departamento')->get();
        $departamentos = Departamento::get();
        return view('rh.puestos.index', compact('departamentos', 'puestos'));
    }

    // Crear nuevo puesto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'string',
            'id_departamento' => 'integer'
        ]);

        Puesto::create($validated  +  ['id_estatus' => 1]);

        return redirect()->back();
    }

    // Actualizar puesto
    public function update(Request $request, $id)
    {
        $puesto = Puesto::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'string',
            'id_departamento' => 'integer'
        ]);
        $puesto->update($validated);
        return back();
    }

    // Eliminar puesto
    public function destroy($id)
    {
        $puesto = Puesto::findOrFail($id);
        $puesto->update(['id_estatus' => 2]);
        $puesto->delete();

        return response('Succes', 200);
    }
}
