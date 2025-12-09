<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\Area;
use App\Models\RH\Departamento;
use App\Models\RH\Puesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isEmpty;

class DepartamentosController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::with('area')->where('id_estatus', 1)->get();
        $areas = Area::get();
        return view('rh.departamentos.index', compact('departamentos', 'areas'));
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
        $puesto = Puesto::where('id_departamento', $id)->where('id_estatus', 1)->get();
        if ($puesto->isNotEmpty()) {
            return response()->json([
                'message' => 'Este departamento tiene puestos asignados. Por favor, deshabilitalos antes de continuar.'
            ], 202);
        } else {
            $departamento = Departamento::findOrFail($id);
            $departamento->update(['id_estatus' => 2]);
            $departamento->delete();

            return response('Succes', 200);
        }
    }
}
