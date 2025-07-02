<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Solo permitir registro público si el sistema lo permite
        // Alternativamente, podrías pasar los roles disponibles a la vista
        // si quieres que el usuario seleccione su rol (solo para casos especiales)
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'a_paterno' => ['required', 'string', 'max:255'],
            'a_materno' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Empleado::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Agregar validación para el rol solo si es necesario
            // 'role' => ['sometimes', 'in:staff,coordinador,gerente,administrador']
        ]);

        $empleadoData = [
            'nombre' => $request->nombre,
            'a_paterno' => $request->a_paterno,
            'a_materno' => $request->a_materno,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff' // Rol por defecto para nuevos registros
        ];

        // Opción: Asignar rol diferente si el registro lo incluye (solo para casos específicos)
        // if ($request->has('role') && auth()->check() && auth()->user()->isAdministrador()) {
        //     $empleadoData['role'] = $request->role;
        // }

        $empleado = Empleado::create($empleadoData);

        event(new Registered($empleado));

        Auth::login($empleado);

        // Redirigir según el rol del usuario
        return $this->redirectByRole($empleado);
    }

    /**
     * Redirige al usuario según su rol después del registro
     */
    protected function redirectByRole(Empleado $empleado): RedirectResponse
    {
        return match ($empleado->role) {
            'administrador' => redirect()->route('admin.dashboard'),
            'gerente' => redirect()->route('management.dashboard'),
            'coordinador' => redirect()->route('coordinator.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }
}
