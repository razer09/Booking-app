<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([ 'auth:sanctum', config('jetstream.auth_session'), 'verified', ])->group(function () {
    Route::get('/dashboard', function () { return Inertia::render('Dashboard'); })->name('dashboard');
    Route::get('/deposit', function () { return Inertia::render('Deposit'); })->name('deposit');
    Route::post('/deposit', [App\Http\Controllers\BankActionsController::class, 'deposit'])->name('deposit.post');
    Route::get('/withdraw', function () { return Inertia::render('Withdraw'); })->name('withdraw');
    Route::post('/withdraw', [App\Http\Controllers\BankActionsController::class, 'withdraw'])->name('withdraw.post');
    Route::get('/transfer', function () { return Inertia::render('Transfer'); })->name('transfer');
    Route::post('/transfer', [App\Http\Controllers\BankActionsController::class, 'transfer'])->name('transfer.post');
    Route::get('/statments', [App\Http\Controllers\BankActionsController::class, 'statments'])->name('statments');
});
