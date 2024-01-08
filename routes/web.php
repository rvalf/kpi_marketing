<?php

use App\Http\Controllers\ActivityController;
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
Route::get('/home-staff', [App\Http\Controllers\DashboardController::class, 'staff'])->name('dashboard.staff');

// User
Route::get('staff/index', [UserController::class, 'index'])->name('staff.index');
Route::get('staff/add', [UserController::class, 'create'])->name('staff.create');
Route::get('staff/edit/{id}', [UserController::class, 'edit'])->name('staff.edit');
Route::get('staff/account/{id}', [UserController::class, 'edit'])->name('staff.account');
Route::post('staff/store', [UserController::class, 'store'])->name('staff.store');
Route::put('staff/update/{id}', [UserController::class, 'update'])->name('staff.update');
Route::delete('staff/delete/{id}', [UserController::class, 'destroy'])->name('staff.delete');

// Divisi
Route::get('divisi/index', [DivisiController::class, 'index'])->name('div.index');
Route::get('divisi/add', [DivisiController::class, 'create'])->name('div.create');
Route::get('divisi/edit/{id}', [DivisiController::class, 'edit'])->name('div.edit');
Route::post('divisi/store', [DivisiController::class, 'store'])->name('div.store');
Route::put('divisi/update/{id}', [DivisiController::class, 'update'])->name('div.update');
Route::delete('divisi/delete/{id}', [DivisiController::class, 'destroy'])->name('div.delete');

// Activity
Route::get('activity/index', [ActivityController::class, 'index'])->name('act.index');
Route::get('activity/add', [ActivityController::class, 'create'])->name('act.create');
Route::get('activity/edit/{id}', [ActivityController::class, 'edit'])->name('act.edit');
Route::post('activity/store', [ActivityController::class, 'store'])->name('act.store');
Route::put('activity/update/{id}', [ActivityController::class, 'update'])->name('act.update');
Route::delete('activity/delete/{id}', [ActivityController::class, 'destroy'])->name('act.delete');