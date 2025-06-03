<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use App\Models\TestPostback;

//Users Routes
Route::match(['post','get'],'/',[UsersController::class,'login'])->name('login');
Route::get('/documentation', [AppsController::class, 'documentations'])->name('documentations');
Route::match(['post','get'],'/reset-password', [UsersController::class, 'resetPassword'])->name('resetPassword');
Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
});
// Routes with Auth Middleware
Route::middleware('auth')->group(function () {
    Route::get('/logout',[UsersController::class,'logout'])->name('users.logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Settings
    Route::match(['post','get'],'/settings', [DashboardController::class, 'setting'])->name('dashboard.setting');

    // Payments
    Route::get('/payment-methods', [PaymentsController::class, 'paymentMethods'])->name('payment.methods');
    Route::get('/now-payments', [PaymentsController::class, 'index'])->name('payment.index');

    // Reports
    Route::get('/statistics', [ReportsController::class, 'statistics'])->name('report.statistics');
    Route::get('/conversions', [ReportsController::class, 'conversions'])->name('report.conversions');
    Route::get('/postbacks', [ReportsController::class, 'postbacks'])->name('report.postbacks');
    Route::get('/exported-reports', [ReportsController::class, 'exported'])->name('report.exported');
    Route::post('/export-report', [ReportsController::class, 'exportReport'])->name('report.export');
    
    // Apps
    Route::get('/apps', [AppsController::class, 'index'])->name('apps.index');
    Route::match(['get','post'],'/add-app/{id?}', [AppsController::class, 'add'])->name('apps.add');
    Route::get('/test-postback', [AppsController::class, 'testPostback'])->name('apps.testpostback');
    Route::get('/integration/{id}', [AppsController::class, 'integration'])->name('apps.integration');
    Route::get('/update-status/{id}', [AppsController::class, 'updateStatus'])->name('apps.status');
    Route::match(['get','post'],'/template/{id}', [AppsController::class, 'template'])->name('apps.template');
    Route::match(['get','post'],'/testPostback', [AppsController::class, 'testPostback'])->name('testPostback');
    Route::get('/get-postback-error/{id}', function ($id) {
        $postback = TestPostback::find($id);
        if (!$postback) {
            return response()->json([
                'postback_url' => 'N/A',
                'http_code' => 'N/A',
                'error_message' => 'Postback not found'
            ], 404);
        }
    
        return response()->json([
            'postback_url' => $postback->postback_url ?? 'N/A',
            'http_code' => $postback->status ?? 'N/A',
            'error_message' => $postback->error_detail ?? 'No error details available'
        ]);
    })->name('postbackerror');
    // Chart Data
    Route::get('/chart-data', [ChartController::class, 'chartData'])->name('chart.data');

    Route::get('/filterGroup/{type?}', [ReportsController::class, 'filterGroup'])->name('filterGroup');
});
