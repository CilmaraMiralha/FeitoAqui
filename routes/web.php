<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PatternController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas de recuperação de senha
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Rotas de usuários
Route::get('/users', [UserController::class, "index"])->name("users.show");
Route::get('/users/create', [UserController::class, "create"])->name("users.create");
Route::post('/users', [UserController::class, "store"])->name("users.store");

// Rotas protegidas (requer autenticação)
Route::middleware('auth')->group(function () {
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    // Rotas de materiais
    Route::resource('materials', MaterialController::class);
    Route::post('/materials/{material}/variations', [MaterialController::class, 'storeVariation'])->name('materials.variations.store');
    Route::put('/materials/{material}/variations/{variation}', [MaterialController::class, 'updateVariation'])->name('materials.variations.update');
    Route::delete('/materials/{material}/variations/{variation}', [MaterialController::class, 'destroyVariation'])->name('materials.variations.destroy');
    Route::post('/materials/{material}/adjust-weight', [MaterialController::class, 'adjustVariationWeight'])->name('materials.variations.adjust');

    // Rotas de rascunhos
    Route::resource('drafts', DraftController::class);

    // Rotas de patterns
    Route::resource('patterns', PatternController::class);
});
