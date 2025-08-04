<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\Area;
use App\Models\RH\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DepartamentosController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::with('area')->paginate(10);
        Log::info($departamentos);
        $areas = Area::get();
        return view('rh.departamentos.index', compact('departamentos','areas'));
    }

    // Crear nuevo departamento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'string',
            'id_area' => 'integer'
        ]);

        Departamento::create($validated  +  ['id_estatus' => 1]);
        Log::info($validated);
        return redirect()->back();
    }

    // Actualizar departamento
    public function update(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'string',
            'id_area' => 'integer'
        ]);
        $departamento->update($validated);
        return back();
    }

    // Eliminar departamento
    public function destroy($id)
    {
        $departamento = Departamento::find($id);
        $departamento->update(['id_estatus' => 2]);

        return redirect()->back();
    }
}
