<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PaymentController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/catalogo', [PageController::class, 'catalogo'])->name('catalogo');
Route::get('/moto/{slug}', [PageController::class, 'ficha'])->name('moto.ficha');
Route::post('/moto/{id}/lead', [PageController::class, 'storeLead'])->name('lead.store');

Route::post('/carrito/add/{id}', [PageController::class, 'addCarrito'])->name('carrito.add');
Route::get('/carrito', [PageController::class, 'carrito'])->name('carrito');
Route::delete('/carrito/{id}', [PageController::class, 'removeFromCart'])->name('carrito.remove');
Route::post('/carrito/clear', [PageController::class, 'clearCart'])->name('carrito.clear');

Route::get('/checkout', [PageController::class, 'checkoutForm'])->name('checkout');
Route::post('/checkout', [PageController::class, 'checkoutProcess'])->name('checkout.process');

Route::post('/create-checkout-session', [PaymentController::class, 'createCheckoutSession'])->name('checkout.session');
Route::get('/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

Route::middleware(['auth'])->group(function () {
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/motos', [AdminController::class, 'motos'])->name('admin.motos');
    Route::get('/admin/motos/{id}/edit', [AdminController::class, 'editMoto'])->name('admin.motos.edit');
    Route::put('/admin/motos/{id}', [AdminController::class, 'updateMoto'])->name('admin.motos.update');
    Route::delete('/admin/motos/{id}', [AdminController::class, 'destroyMoto'])->name('admin.motos.destroy');

    Route::post('/admin/motos/{id}/status', [AdminController::class, 'changeStatus'])->name('admin.motos.changeStatus');

    Route::get('/admin/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::delete('/admin/usuarios/{id}', [AdminController::class, 'destroyUsuario'])->name('admin.usuarios.destroy');
});

require __DIR__ . '/auth.php';