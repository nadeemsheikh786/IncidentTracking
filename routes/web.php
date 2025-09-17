<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\Admin\IncidentAdminController;
use App\Http\Controllers\CommentController;

// Auth
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Incidents
Route::middleware('auth')->group(function () {
    Route::get('/', fn() => redirect()->route('incidents.index'));
    Route::get('/incidents', [IncidentController::class, 'index'])->name('incidents.index');
    Route::get('/incidents/create', [IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');
    Route::get('/incidents/{incident}', [IncidentController::class, 'show'])->name('incidents.show');

    // Comments (AJAX)
    Route::post('/incidents/{incident}/comments', [CommentController::class, 'store'])->name('comments.store');

    // Admin manage
    Route::middleware('role:admin')->group(function(){
        Route::get('/admin/incidents/{incident}/edit', [IncidentAdminController::class, 'edit'])->name('admin.incidents.edit');
        Route::put('/admin/incidents/{incident}', [IncidentAdminController::class, 'update'])->name('admin.incidents.update');
    });
});
