<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    //
    public function index()
    {
        $empresas = Empresa::paginate(10);
        return view('rh.empresas.index', compact('empresas'));
    }

    // Crear nuevo empresa
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'string',
        ]);

        Empresa::create($validated  +  ['id_estatus' => 1]);

        return redirect()->back();
    }

    // Actualizar empresa
    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'string',
        ]);
        $empresa->update($validated);
        return back();
    }

    // Eliminar empresa
    public function destroy($id)
    {
        $empresa = Empresa::find($id);
        $empresa->update(['id_estatus' => 2]);

        return redirect()->back();
    }
}
