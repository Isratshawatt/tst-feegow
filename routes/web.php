<?php

use App\Http\Controllers\ConsultaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::controller(ConsultaController::class)->middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    
    /* Prefixo de Consulta */
    Route::prefix('consulta')->group(function () {
        Route::get('/agendar', 'agendarConsulta')->name('consulta.agendar');
    });

    /* Prefixo médicos */
    Route::prefix('medicos')->group(function () {
        Route::post('/especialidade/{especialidadeId}', 'consultarMedicosPorEspecialidade')->name('consulta.medicos.especialidade');
        Route::post('/agendar', 'agendarConsultaMedico')->name('agendar.consulta.medicos');
        Route::post('/horarios', 'buscarHorariosDisponiveis')->name('medicos.horarios.disponivel');
        Route::post('/cancelar', 'cancelarConsulta')->name('cancelar.agendamento');
    });
});

require __DIR__.'/auth.php';
