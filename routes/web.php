<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth as AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});




Route::prefix("/user")->group(function () {

    Route::get('/create', [UserController::class, 'create'])->name('user.create');

    Route::post('/store', [UserController::class, 'store'])->name('user.store');

    Route::middleware('auth')->group(function () {
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');

        Route::post('/update', [UserController::class, 'update'])->name('user.update');

        Route::get('/', [UserController::class, 'index'])->name('user.index');

        Route::get('/profile/{id}', [UserController::class, 'show'])->name('user.profile');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
});
