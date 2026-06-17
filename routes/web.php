<?php

use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\PublicEventController;
use App\Http\Middleware\EnsureOrganizador;
use App\Http\Middleware\EnsureParticipante;
use Illuminate\Support\Facades\Route;

// ─── Portal Público ──────────────────────────────────────────────────────────
Route::get('/', [PublicEventController::class, 'index'])->name('home');
Route::get('/eventos/{event}', [PublicEventController::class, 'show'])->name('events.show');

// ─── Autenticação (apenas para visitantes) ───────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/cadastro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/cadastro', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Backoffice do Organizador ───────────────────────────────────────────────
Route::middleware(['auth', EnsureOrganizador::class])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
         Route::resource('events', AdminEventController::class)->except(['show']);
     });

// ─── Área do Participante ────────────────────────────────────────────────────
Route::middleware(['auth', EnsureParticipante::class])
     ->name('participant.')
     ->group(function () {
         Route::get('/minhas-inscricoes', [InscriptionController::class, 'index'])->name('inscriptions.index');
         Route::post('/eventos/{event}/inscrever', [InscriptionController::class, 'store'])->name('inscriptions.store');
         Route::delete('/eventos/{event}/cancelar', [InscriptionController::class, 'destroy'])->name('inscriptions.destroy');
     });
