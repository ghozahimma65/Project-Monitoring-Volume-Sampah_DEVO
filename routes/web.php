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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes (No Authentication Required)
Route::get('/', [PublicDashboardController::class, 'index'])->name('dashboard');
Route::get('/depo/{depo}', [PublicDashboardController::class, 'show'])->name('depo.detail');
Route::get('/api/dashboard', [PublicDashboardController::class, 'api'])->name('api.dashboard');
Route::get('/api/depo/{depo}/chart', [PublicDashboardController::class, 'getChartData'])->name('api.depo.chart');

// Public Report Routes
Route::prefix('laporan')->name('report.')->group(function () {
    Route::get('/', [PublicReportController::class, 'index'])->name('index');
    Route::post('/', [PublicReportController::class, 'store'])->name('store');
    Route::get('/lacak', [PublicReportController::class, 'track'])->name('track');
    Route::post('/status', [PublicReportController::class, 'getReportStatus'])->name('status');
});
// Di file routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/reports', [ReportController::class, 'index']);
    // route lainnya...
});

// Authentication Routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
// Di routes/web.php
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    // Logic login di sini
})->name('login.post');


// Admin Routes (Authentication Required)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [AdminDashboardController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/read', [AdminDashboardController::class, 'markNotificationsRead'])->name('notifications.read');

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
});

// routes/web.php
Route::post('/report/store', [ReportController::class, 'store'])->name('report.store');
Route::get('/report/review', [ReportController::class, 'review'])->name('report.review');

// About Page
Route::get('/about', function () {
    return view('public.about');
})->name('about');


// Test routes (remove after testing)
Route::get('/test-critical', [TestNotificationController::class, 'testCritical']);
Route::get('/test-warning', [TestNotificationController::class, 'testWarning']);  
Route::get('/test-normal', [TestNotificationController::class, 'testNormal']);


// Routes untuk public report
Route::get('/report', [ReportController::class, 'create'])->name('report.create');
Route::post('/report', [ReportController::class, 'store'])->name('report.store');
Route::get('/report/list', [ReportController::class, 'getPublicReports'])->name('report.public.list');

// Routes untuk admin (jika belum ada)
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('admin.reports.show');
    Route::patch('/reports/{report}/status', [ReportController::class, 'updateStatus'])->name('admin.reports.update-status');

Route::get('logs', [LogViewerController::class, 'index']);




});
?>