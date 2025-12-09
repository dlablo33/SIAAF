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

use App\Http\Controllers\ExcelController;
use App\Http\Controllers\RH\RetardosController;
use App\Http\Controllers\RH\AreasController;
use App\Http\Controllers\RH\DeduccionesController;
use App\Http\Controllers\RH\DepartamentosController;
use App\Http\Controllers\RH\DispersionController;
use App\Http\Controllers\RH\DocumentoController;
use App\Http\Controllers\RH\EmpleadosController;
use App\Http\Controllers\RH\EmpresaController;
use App\Http\Controllers\RH\NominaController;
use App\Http\Controllers\RH\PermisoTipoController;
use App\Http\Controllers\RH\PrestacionesController;
use App\Http\Controllers\RH\PuestosController;
use App\Models\RH\PermisoTipo;
use App\Http\Controllers\Cotizadora\CotizadoraController;
use App\Http\Controllers\RH\PrestamosController;
use App\Http\Controllers\RH\ReportesController;
use App\Http\Controllers\RH\SolicitudController;
use App\Models\RH\Prestaciones;

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
    //Solicitudes
    Route::get('solicitud', [SolicitudController::class, 'index'])->name('solicitud.index');
    Route::post('solicitud/getSolicitud', [SolicitudController::class, 'getSolicitud'])->name('solicitud.getSolicitud');
    Route::post('solicitud/updateSolicitud', [SolicitudController::class, 'updateSolicitud'])->name('solicitud.updateSolicitud');

    Route::get('solicitud/vacaciones', [SolicitudController::class, 'vacaciones'])->name('solicitud.vacaciones');
    Route::post('solicitud/vacaciones/save', [SolicitudController::class, 'saveVacaciones'])->name('solicitud.saveVacaciones');
    Route::get('solicitud/permiso', [SolicitudController::class, 'permiso'])->name('solicitud.permiso');
    Route::post('solicitud/permiso/save', [SolicitudController::class, 'savePermiso'])->name('solicitud.saveVacaciones');
    Route::get('solicitud/prestamo', [SolicitudController::class, 'prestamo'])->name('solicitud.prestamo');
    Route::post('solicitud/prestamo/save', [SolicitudController::class, 'savePrestamo'])->name('solicitud.savePrestamo');

    // Nomina
    Route::get('nomina/{periodo}', [NominaController::class, 'index'])->name('nomina.index');
    Route::get('nomina/{periodo}/check', [ReportesController::class, 'checkReporte'])->name('nomina.checkReporte');
    Route::get('nomina/{periodo}/check-all', [ReportesController::class, 'checkReportes'])->name('nomina.checkReportes');
    Route::post('nomina/{periodo}/reporte', [ReportesController::class, 'generateReporte'])->name('nomina.generateReporte');
    Route::get('nomina/{periodo}/reporte/download', [ReportesController::class, 'getReporte'])->name('nomina.getReporte');

    // Dispersion
    Route::get('dispersion/{periodo}', [DispersionController::class, 'index'])->name('dispersion.index');

    // Retardos
    Route::get('retardos/{periodo}', [RetardosController::class, 'index'])->name('retardos.index');
    Route::post('retardos/import', [ExcelController::class, 'checadorImport'])->name('retardos.import');

    // Empleados
    Route::resource('empleados', EmpleadosController::class);
    Route::post('empleados/updatePassword', [EmpleadosController::class, 'updatePassword'])->name('empleados.updatePassword');

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

    //Prestamos
    Route::get('prestamos', [PrestamosController::class, 'index'])->name('prestamos.index');
    Route::get('prestamos/getHistorial', [PrestamosController::class, 'getHistorial'])->name('empleados.getHistorial');
    Route::get('prestamos/calculadora', [PrestamosController::class, 'calculadora'])->name('prestamos.calculadora');

    // Deducciones
    Route::resource('deducciones', DeduccionesController::class);

    // Documento
    Route::resource('documentos', DocumentoController::class);
});


Route::resource('clients', LegalClientController::class);

// Rutas adicionales para documentos
Route::get('/clients/{client}/documents', [LegalClientController::class, 'showDocuments'])
    ->name('clients.documents');

Route::get('/clients/{client}/download/{document}', [LegalClientController::class, 'downloadDocument'])
    ->name('clients.download');

Route::get('/cotizadora', [CotizadoraController::class, 'index'])->name('cotizadora.index');
Route::post('/cotizaciones/guardar', [CotizadoraController::class, 'guardar'])->name('cotizaciones.guardar');
// Rutas para el módulo legal
Route::prefix('legal')->name('legal.')->group(function () {
    // Ruta para verificar RFC (DEBE ir antes del resource)
    Route::post('/clients/check-rfc', [LegalClientController::class, 'checkRfc'])
        ->name('clients.check-rfc');

    // Rutas resource para clients
    Route::resource('clients', LegalClientController::class);
});
// routes/web.php
Route::middleware(['auth'])->prefix('legal')->group(function () {
    Route::resource('clients', App\Http\Controllers\Legal\LegalClientController::class);
});
Route::prefix('legal')->name('legal.')->group(function () {
    Route::resource('clients', LegalClientController::class);
});
