<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\TransactionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () { return view('login');});
Route::get('/register', function () { return view('registration'); });

Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/register',[AuthController::class,'register'])->name('register');

Route::middleware(['WebGuard'])->group(function () {
Route::get('/home',[AuthController::class,'home'])->name('home');  
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/edit/{id}/', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::post('/transactions/update/', [TransactionController::class, 'update'])->name('transactions.update');

Route::get('/transactions/disable/{id}', [TransactionController::class, 'disable'])->name('transactions.disable');


});
