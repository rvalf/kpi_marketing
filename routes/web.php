<?php

use App\Http\Controllers\DivisiController;
use App\Http\Controllers\UserController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// User
Route::get('staff/index', [UserController::class, 'index'])->name('staff.index');

// Divisi
Route::get('divisi/index', [DivisiController::class, 'index'])->name('div.index');
Route::get('divisi/add', [DivisiController::class, 'create'])->name('div.create');
Route::post('divisi/store', [DivisiController::class, 'store'])->name('div.store');