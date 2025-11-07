<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\Documento;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    //
    public function index()
    {
        $documentos = Documento::paginate(10);
        return view('rh.documentos.index', compact('documentos'));
    }

    // Crear nueva documento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'string',
            'vigencia' => 'string'
        ]);

        Documento::create($validated  +  ['id_estatus' => 1]);

        return redirect()->back();
    }

    // Actualizar documento
    public function update(Request $request, $id)
    {
        $documento = Documento::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'string',
            'vigencia' => 'string'
        ]);
        $documento->update($validated);
        return back();
    }

    // Eliminar documento
    public function destroy($id)
    {
        $documento = Documento::find($id);
        $documento->update(['id_estatus' => 2]);

        return redirect()->back();
    }
}
