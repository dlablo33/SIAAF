<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Legal\LegalClientController;
use App\Http\Controllers\Legal\CompanyController;
use App\Http\Controllers\Legal\DocumentController;
use App\Http\Controllers\Legal\RequirementController;
use App\Http\Controllers\Legal\AdviceController;
use App\Http\Controllers\Legal\ProcedureController;
use App\Http\Controllers\Legal\AppointmentController;

use App\Http\Controllers\Cotizadora\CotizadorController;
use App\Http\Controllers\RetardosController;
use App\Http\Controllers\RH\AreasController;
use App\Http\Controllers\RH\DeduccionesController;
use App\Http\Controllers\RH\DepartamentosController;
use App\Http\Controllers\RH\DocumentoController;
use App\Http\Controllers\RH\EmpleadosController;
use App\Http\Controllers\RH\EmpresaController;
use App\Http\Controllers\RH\NominaController;
use App\Http\Controllers\RH\PermisoTipoController;
use App\Http\Controllers\RH\PrestacionesController;
use App\Http\Controllers\RH\PuestosController;
use App\Models\RH\PermisoTipo;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::prefix('legal')->name('legal.')->middleware(['auth'])->group(function () {
    // Clientes
    Route::resource('clients', LegalClientController::class);

    // Empresas
    Route::resource('companies', CompanyController::class);

    // Documentos
    Route::resource('documents', DocumentController::class);

    // Requisitos
    Route::resource('requirements', RequirementController::class);

    // Asesorías
    Route::resource('advices', AdviceController::class);

    // Trámites
    Route::resource('procedures', ProcedureController::class);

    // Citas
    Route::resource('appointments', AppointmentController::class);

    // Rutas adicionales
    Route::get('clients/{client}/documents', [LegalClientController::class, 'documents'])->name('clients.documents');
    Route::get('documents/expiring', [DocumentController::class, 'expiring'])->name('documents.expiring');
});

Route::prefix('rh')->name('rh.')->middleware(['auth'])->group(function () {
    // Nomina
    Route::resource('nomina', NominaController::class);

    // Retardos
    Route::get('retardos/{periodo}', [RetardosController::class, 'index'])
        ->name('retardos.index');

    // Empleados
    Route::resource('empleados', EmpleadosController::class);
    Route::post('empleados/updatePassword', [EmpleadosController::class ,'updatePassword'])->name('empleados.updatePassword');

    // Areas
    Route::resource('areas', AreasController::class);

    // Departamentos
    Route::resource('departamentos', DepartamentosController::class);

    // Puestos
    Route::resource('puestos', PuestosController::class);

    // Empresas
    Route::resource('empresas', EmpresaController::class);

    // PermisoTipo
    Route::resource('permisoTipo', PermisoTipoController::class);

    // Prestaciones
    Route::resource('prestaciones', PrestacionesController::class);

    // Deducciones
    Route::resource('deducciones', DeduccionesController::class);

    // Documento
    Route::resource('documentos', DocumentoController::class);
});

Route::get('/import', [\App\Http\Controllers\ExcelController::class, 'checadorImport']);

Route::resource('clients', LegalClientController::class);

// Rutas adicionales para documentos
Route::get('/clients/{client}/documents', [LegalClientController::class, 'showDocuments'])
    ->name('clients.documents');

Route::get('/clients/{client}/download/{document}', [LegalClientController::class, 'downloadDocument'])
    ->name('clients.download');
