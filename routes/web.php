<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\TransactionController;
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
    return redirect()->route('login');
});


// guest routes
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register', [RegistrationController::class, 'create'])->name('register');
    Route::post('/register', [RegistrationController::class, 'store']);
});


// auth routes
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/deposit', [TransactionController::class, 'showDepositForm'])->name('deposit');
    Route::post('/deposit', [TransactionController::class, 'depositMoney']);

    Route::get('/withdraw', [TransactionController::class, 'showWithdrawForm'])->name('withdraw');
    Route::post('/withdraw', [TransactionController::class, 'withDrawMoney']);
    
    Route::get('/transfer', [TransactionController::class, 'showTransferForm'])->name('transfer');
    Route::post('/transfer', [TransactionController::class, 'transfer']);
    
    Route::get('/statement', [TransactionController::class, 'statement'])->name('statement');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
