<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\RH\Empresa;
use App\Models\RH\Puesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Auth;

class EmpleadosController extends Controller
{
    // Mostrar lista de empleados con nomina
    public function index()
    {
        $empleados = Empleado::where('id_estatus',1)->orderby('a_paterno')->paginate(10);

        return view('rh.empleados.index', compact('empleados'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $empresas = Empresa::get();
        $puestos = Puesto::get();
        return view('rh.empleados.create', compact('empresas','puestos'));
    }

    // Mostrar detalles del empleado
    public function show(Empleado $empleado)
    {
        $empleado->load('puesto');
        return view('rh.empleados.show', compact('empleado'));
    }

    // Guardar empleado nuevo
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'nullable|string',
            'a_paterno' => 'nullable|string',
            'a_materno' => 'nullable|string',
            'correo_interno' => 'nullable|string',
            'correo_personal' => 'nullable|string',
            'foto_perfil' => 'nullable|string',
            'curp' => 'nullable|string',
            'rfc' => 'nullable|string',
            'nss' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|string',
            'genero' => 'nullable|string',
            'nacionalidad' => 'nullable|string',
            'id_domicilio' => 'nullable|string',
            'telefono' => 'nullable|string',
            'contacto' => 'nullable|string',
            'contacto_telefono' => 'nullable|string',
            'id_empresa' => 'nullable|string',
            'id_puesto' => 'nullable|string',
            'fecha_ingreso' => 'nullable|string',
            'fecha_baja' => 'nullable|string',
            'fecha_reingreso' => 'nullable|string',
            'id_estatus' => 'nullable|string',
        ]);

        $empleado = Empleado::create($validated +  ['id_estatus' => 1]);
        return $empleado->id;
    }

    // Mostrar formulario de edición
    public function edit(Empleado $empleado)
    {
        return view('rh.empleados.edit', compact('empleado',));
    }

    // Mostrar formulario de edición
    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);
        Log::info("empleado:  $empleado");

        $validated = $request->validate([
            'nombre' => 'nullable|string',
            'a_paterno' => 'nullable|string',
            'a_materno' => 'nullable|string',
            'correo_interno' => 'nullable|string',
            'correo_personal' => 'nullable|string',
            'foto_perfil' => 'nullable|string',
            'curp' => 'nullable|string',
            'rfc' => 'nullable|string',
            'nss' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|string',
            'genero' => 'nullable|string',
            'nacionalidad' => 'nullable|string',
            'id_domicilio' => 'nullable|string',
            'telefono' => 'nullable|string',
            'contacto' => 'nullable|string',
            'contacto_telefono' => 'nullable|string',
            'id_empresa' => 'nullable|string',
            'id_puesto' => 'nullable|string',
            'fecha_ingreso' => 'nullable|string',
            'fecha_baja' => 'nullable|string',
            'fecha_reingreso' => 'nullable|string',
            'id_estatus' => 'nullable|string',
        ]);

        $empleado->update($validated);
        return back();
    }

    // Eliminar empleado
    public function destroy($id)
    {
        $empleado = Empleado::find($id);
        $empleado->update(['id_estatus' => 2]);

        return redirect()->route('rh.empleados.index')
            ->with('success', 'Cliente eliminado correctamente');
    }

    // Cambiar la contraseña del usuario
    public function updatePassword(Request $request)
    {
        // $actual = Auth::user()->password;
        $new = $request->password_new;
        $old = $request->password_old;

        // if (Hash::check($old, $actual)) {
            // Log::info("Password Verified");
            // User::where('id', Auth::user()->id)->update(['password' => Hash::make($new)]);
        // }

        return;
    }
}
