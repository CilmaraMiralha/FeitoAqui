<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PatternController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Rota de busca de receitas (pública)
Route::get('/patterns/search', [PatternController::class, 'search'])->name('patterns.search');

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
    Route::get('/drafts/{draft}/publish', [DraftController::class, 'publish'])->name('drafts.publish');
    Route::post('/drafts/{draft}/publish', [DraftController::class, 'storePattern'])->name('drafts.store-pattern');

    // Rotas de patterns
    Route::resource('patterns', PatternController::class);

    // Rotas de carrinho de compras
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{pattern}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

    // Rotas de pedidos
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::get('/my-patterns', [App\Http\Controllers\OrderController::class, 'myPatterns'])->name('orders.my-patterns');

    // Rotas de comentários
    Route::post('/patterns/{pattern}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

    // Rotas de avaliações
    Route::post('/patterns/{pattern}/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Rotas administrativas
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/patterns/pending', [App\Http\Controllers\AdminController::class, 'pendingPatterns'])->name('patterns.pending');
        Route::post('/patterns/{pattern}/approve', [App\Http\Controllers\AdminController::class, 'approvePattern'])->name('patterns.approve');
        Route::post('/patterns/{pattern}/reject', [App\Http\Controllers\AdminController::class, 'rejectPattern'])->name('patterns.reject');
        Route::get('/patterns', [App\Http\Controllers\AdminController::class, 'patterns'])->name('patterns.index');
        Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users.index');
        Route::post('/users/{user}/ban', [App\Http\Controllers\AdminController::class, 'banUser'])->name('users.ban');
        Route::post('/users/{user}/unban', [App\Http\Controllers\AdminController::class, 'unbanUser'])->name('users.unban');
        Route::delete('/comments/{comment}', [App\Http\Controllers\AdminController::class, 'deleteComment'])->name('comments.destroy');
        Route::get('/orders', [App\Http\Controllers\AdminController::class, 'orders'])->name('orders.index');
    });
});
