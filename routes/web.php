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
Route::get('staff/index', [UserController::class, 'index'])->name('staff.index')->middleware('auth');
Route::get('staff/add', [UserController::class, 'create'])->name('staff.create')->middleware('auth');
Route::get('staff/edit/{id}', [UserController::class, 'edit'])->name('staff.edit')->middleware('auth');
Route::get('staff/account/{id}', [UserController::class, 'edit'])->name('staff.account')->middleware('auth');
Route::post('staff/store', [UserController::class, 'store'])->name('staff.store')->middleware('auth');
Route::put('staff/update/{id}', [UserController::class, 'update'])->name('staff.update')->middleware('auth');
Route::delete('staff/delete/{id}', [UserController::class, 'destroy'])->name('staff.delete')->middleware('auth');

Route::get('staff/show-profile', [UserController::class, 'showProfile'])->name('staff.showprofile')->middleware('auth');


// Divisi
Route::get('divisi/index', [DivisiController::class, 'index'])->name('div.index');
Route::get('divisi/add', [DivisiController::class, 'create'])->name('div.create');
Route::get('divisi/edit/{id}', [DivisiController::class, 'edit'])->name('div.edit');
Route::post('divisi/store', [DivisiController::class, 'store'])->name('div.store');
Route::put('divisi/update/{id}', [DivisiController::class, 'update'])->name('div.update');
Route::delete('divisi/delete/{id}', [DivisiController::class, 'destroy'])->name('div.delete');

Route::middleware(['checkDivisi'])->group(function () {
    Route::get('/home', [App\Http\Controllers\DashboardController::class, 'index'])->name('home')->middleware('auth');

    // Activity
    Route::get('activity/index', [ActivityController::class, 'index'])->name('act.index')->middleware('auth');
    Route::get('activity/add', [ActivityController::class, 'create'])->name('act.create')->middleware('auth');
    Route::get('activity/edit/{id}', [ActivityController::class, 'edit'])->name('act.edit')->middleware('auth');
    Route::post('activity/store', [ActivityController::class, 'store'])->name('act.store')->middleware('auth');
    Route::put('activity/update/{id}', [ActivityController::class, 'update'])->name('act.update')->middleware('auth');
    Route::delete('activity/delete/{id}', [ActivityController::class, 'destroy'])->name('act.delete')->middleware('auth');
    
    // Initiative
    Route::get('initiative/index', [InitiativeController::class, 'index'])->name('init.index')->middleware('auth');
    Route::get('initiative/add/{act_id}', [InitiativeController::class, 'create'])->name('init.create')->middleware('auth');
    Route::get('initiative/edit/{id}', [InitiativeController::class, 'edit'])->name('init.edit')->middleware('auth');
    Route::post('initiative/store', [InitiativeController::class, 'store'])->name('init.store')->middleware('auth');
    Route::put('initiative/update/{id}', [InitiativeController::class, 'update'])->name('init.update')->middleware('auth');
    Route::delete('initiative/delete/{id}', [InitiativeController::class, 'destroy'])->name('init.delete')->middleware('auth');
});

// Performance Report
Route::get('report/index', [PerformanceReportController::class, 'index'])->name('report.index')->middleware('auth');
Route::get('report/add/{init_id}', [PerformanceReportController::class, 'create'])->name('report.create')->middleware('auth');
Route::post('report/store/{initiative_id}', [PerformanceReportController::class, 'store'])->name('report.store')->middleware('auth');
Route::delete('report/delete/{id}', [PerformanceReportController::class, 'destroy'])->name('report.destroy')->middleware('auth');
Route::post('/upload/{id}', [PerformanceReportController::class, 'uploadFile'])->name('report.upload')->middleware('auth');
Route::get('/download/{file}', [PerformanceReportController::class, 'downloadFile'])->name('report.download')->middleware('auth');

Route::get('/scoreboard-detail/{id}', [DashboardController::class, 'detailReportActivity'])->name('dashboard.detail')->middleware('auth');

// ajax chart
Route::get('/chart-data', [PerformanceReportController::class, 'getData'])->middleware('auth');
Route::get('/chart-dashboard-detail/{activity_id}', [PerformanceReportController::class, 'getReportByActivity'])->middleware('auth');
Route::get('/chart-activity-wig', [PerformanceReportController::class, 'getDataWIG'])->middleware('auth');
Route::get('/chart-activity-ig', [PerformanceReportController::class, 'getDataIG'])->middleware('auth');
Route::get('/chart-export-wig/{activity_id}', [PerformanceReportController::class, 'getDataExportWIG'])->middleware('auth');
Route::get('/chart-export-ig', [PerformanceReportController::class, 'getDataExportIG'])->middleware('auth');

Route::get('/export-pdf', [DashboardController::class, 'exportPdf'])->name('export.pdf')->middleware('auth');

// Perhitungan bobot
Route::get('/progres-data/{activity_id}', [InitiativeController::class, 'getProgres'])->middleware('auth');
Route::get('/my-task-data', [DashboardController::class, 'countMyTask'])->middleware('auth');
Route::get('/dept-task-data', [DashboardController::class, 'donutChartDept'])->middleware('auth');
Route::get('/getdata', [DashboardController::class, 'getDataPerhitungan'])->middleware('auth');