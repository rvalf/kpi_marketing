<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\InitiativeController;
use App\Http\Controllers\PerformanceReportController;
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
    if (Auth::check()) {
        return redirect('/home');
    }
    return redirect('/login');
});

Auth::routes();

// User
Route::get('staff/index', [UserController::class, 'index'])->name('staff.index');
Route::get('staff/add', [UserController::class, 'create'])->name('staff.create');
Route::get('staff/edit/{id}', [UserController::class, 'edit'])->name('staff.edit');
Route::get('staff/account/{id}', [UserController::class, 'edit'])->name('staff.account');
Route::post('staff/store', [UserController::class, 'store'])->name('staff.store');
Route::put('staff/update/{id}', [UserController::class, 'update'])->name('staff.update');
Route::delete('staff/delete/{id}', [UserController::class, 'destroy'])->name('staff.delete');

Route::get('staff/show-profile', [UserController::class, 'showProfile'])->name('staff.showprofile');


// Divisi
Route::get('divisi/index', [DivisiController::class, 'index'])->name('div.index');
Route::get('divisi/add', [DivisiController::class, 'create'])->name('div.create');
Route::get('divisi/edit/{id}', [DivisiController::class, 'edit'])->name('div.edit');
Route::post('divisi/store', [DivisiController::class, 'store'])->name('div.store');
Route::put('divisi/update/{id}', [DivisiController::class, 'update'])->name('div.update');
Route::delete('divisi/delete/{id}', [DivisiController::class, 'destroy'])->name('div.delete');

Route::middleware(['checkDivisi'])->group(function () {
    Route::get('/home', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');

    // Activity
    Route::get('activity/index', [ActivityController::class, 'index'])->name('act.index');
    Route::get('activity/add', [ActivityController::class, 'create'])->name('act.create');
    Route::get('activity/edit/{id}', [ActivityController::class, 'edit'])->name('act.edit');
    Route::post('activity/store', [ActivityController::class, 'store'])->name('act.store');
    Route::put('activity/update/{id}', [ActivityController::class, 'update'])->name('act.update');
    Route::delete('activity/delete/{id}', [ActivityController::class, 'destroy'])->name('act.delete');
    
    // Initiative
    Route::get('initiative/index', [InitiativeController::class, 'index'])->name('init.index');
    Route::get('initiative/add/{act_id}', [InitiativeController::class, 'create'])->name('init.create');
    Route::get('initiative/edit/{id}', [InitiativeController::class, 'edit'])->name('init.edit');
    Route::post('initiative/store', [InitiativeController::class, 'store'])->name('init.store');
    Route::put('initiative/update/{id}', [InitiativeController::class, 'update'])->name('init.update');
    Route::delete('initiative/delete/{id}', [InitiativeController::class, 'destroy'])->name('init.delete');
});

// Performance Report
Route::get('report/index', [PerformanceReportController::class, 'index'])->name('report.index');
Route::get('report/add/{init_id}', [PerformanceReportController::class, 'create'])->name('report.create');
Route::post('report/store/{initiative_id}', [PerformanceReportController::class, 'store'])->name('report.store');
Route::delete('report/delete/{id}', [PerformanceReportController::class, 'destroy'])->name('report.destroy');
Route::post('/upload/{id}', [PerformanceReportController::class, 'uploadFile'])->name('report.upload');
Route::get('/download/{file}', [PerformanceReportController::class, 'downloadFile'])->name('report.download');

Route::get('/scoreboard-detail/{id}', [DashboardController::class, 'detailReportActivity'])->name('dashboard.detail');

// ajax chart
Route::get('/chart-data', [PerformanceReportController::class, 'getData']);
Route::get('/chart-dashboard-detail/{activity_id}', [PerformanceReportController::class, 'getReportByActivity']);
Route::get('/chart-activity-wig', [PerformanceReportController::class, 'getDataWIG']);
Route::get('/chart-activity-ig', [PerformanceReportController::class, 'getDataIG']);

Route::get('/export-pdf', [DashboardController::class, 'exportPdf']);

// Perhitungan bobot
Route::get('/progres-data/{activity_id}', [InitiativeController::class, 'getProgres']);
Route::get('/my-task-data', [DashboardController::class, 'countMyTask']);
Route::get('/getdata', [DashboardController::class, 'getDataPerhitungan']);
