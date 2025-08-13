<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DepoController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\TestNotificationController;
use App\Http\Controllers\Public\PublicReportController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Public\PublicDashboardController;
use App\Http\Controllers\Api\SensorApiController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use App\Http\Controllers\Admin\AbnormalReadingController;
use App\Http\Controllers\Admin\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == PUBLIC ROUTES ==
Route::get('/', [PublicDashboardController::class, 'index'])->name('dashboard');
Route::get('/depo/{depo}', [PublicDashboardController::class, 'show'])->name('depo.detail');
Route::get('/api/dashboard', [PublicDashboardController::class, 'api'])->name('api.dashboard');
Route::get('/api/depo/{depo}/chart', [PublicDashboardController::class, 'getChartData'])->name('api.depo.chart');
Route::get('/about', function () { return view('public.about'); })->name('about');

// Public Report Routes
Route::prefix('laporan')->name('report.')->group(function () {
    Route::get('/', [PublicReportController::class, 'index'])->name('index');
    Route::post('/', [PublicReportController::class, 'store'])->name('store');
    Route::get('/lacak', [PublicReportController::class, 'track'])->name('track');
    Route::post('/status', [PublicReportController::class, 'getReportStatus'])->name('status');
});

// == AUTHENTICATION ROUTES ==
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// == ADMIN ROUTES (SEMUA DI DALAM SATU GRUP YANG BENAR) ==
// PERUBAHAN UTAMA: Memanggil class middleware secara langsung
Route::middleware(['auth', \App\Http\Middleware\AdminAuth::class])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Notifications & Warnings
    Route::get('notifications/latest', [NotificationController::class, 'getLatest'])->name('notifications.latest');
    Route::put('warnings/{warning}/acknowledge', [AbnormalReadingController::class, 'acknowledge'])->name('warnings.acknowledge');

    // Depo Management
    Route::prefix('depos')->name('depos.')->group(function () {
        Route::get('/', [DepoController::class, 'index'])->name('index');
        Route::get('/create', [DepoController::class, 'create'])->name('create');
        Route::post('/', [DepoController::class, 'store'])->name('store');
        Route::get('/{depo}', [DepoController::class, 'show'])->name('show');
        Route::get('/{depo}/edit', [DepoController::class, 'edit'])->name('edit');
        Route::put('/{depo}', [DepoController::class, 'update'])->name('update');
        Route::delete('/{depo}', [DepoController::class, 'destroy'])->name('destroy');
        Route::post('/preview-calculation', [DepoController::class, 'previewCalculation'])->name('preview-calculation');
    });

    // Report Management
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/{report}', [ReportController::class, 'show'])->name('show');
        Route::put('/{report}/status', [ReportController::class, 'updateStatus'])->name('update-status');
    });

    // Log Viewer
    Route::get('logs', [LogViewerController::class, 'index'])->name('logs');
});


// == TEST ROUTES (Bisa dihapus jika sudah tidak dipakai) ==
Route::get('/test-critical', [TestNotificationController::class, 'testCritical']);
Route::get('/test-warning', [TestNotificationController::class, 'testWarning']);
Route::get('/test-normal', [TestNotificationController::class, 'testNormal']);
