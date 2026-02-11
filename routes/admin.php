<?php

use App\Http\Controllers\DashboardAdmin\BootcampController;
use App\Http\Controllers\DashboardAdmin\CategoryController;
use App\Http\Controllers\DashboardAdmin\CourseController;
use App\Http\Controllers\DashboardAdmin\DataAffiliateController;
use App\Http\Controllers\DashboardAdmin\DataMentorController;
use App\Http\Controllers\DashboardAdmin\DataPesertaController;
use App\Http\Controllers\DashboardAdmin\DiscountController;
use App\Http\Controllers\DashboardAdmin\LaporanController;
use App\Http\Controllers\DashboardAdmin\NewsController;
use App\Http\Controllers\DashboardAdmin\RatingController;
use App\Http\Controllers\DashboardAdmin\MainController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin'])->group(function () {
    Route::prefix('dashboard-admin')->name('admin.')->group(function () {
        Route::get('/beranda', [MainController::class, 'show'])->name('beranda');

        // Notifikasi admin
        Route::get('/notifications', [MainController::class, 'getNotifications'])->name('notifications');

        Route::resource('bootcamp', BootcampController::class);

        Route::resource('categories', CategoryController::class);
        Route::patch('/categories/{categoryId}/courses/{courseId}/approve', [CategoryController::class, 'approve'])->name('courses.approve');
        Route::patch('/categories/{categoryId}/courses/{courseId}/publish', [CategoryController::class, 'publish'])->name('courses.publish');
        Route::patch('/categories/{categoryId}/courses/{courseId}/hidden', [CategoryController::class, 'hiddencourse'])->name('courses.hidden');

        Route::get('/courses/{categoryId}/{courseId}', [CourseController::class, 'show'])->name('courses.show');

        Route::resource('data-affiliate', DataAffiliateController::class)->except(['store', 'update']);

        Route::resource('data-mentor', DataMentorController::class)->only(['index', 'create', 'show', 'destroy']);
        Route::post('/data-mentor/{id}/status/inactive', [DataMentorController::class, 'updateStatusToInactive'])->name('data-mentor.status.inactive');
        Route::post('/data-mentor/{id}/status/active', [DataMentorController::class, 'updateStatus'])->name('data-mentor.status.active');
        Route::post('/data-mentor/toggle-status', [DataMentorController::class, 'toggleActive'])->name('data-mentor.toggle-status');

        Route::resource('data-peserta', DataPesertaController::class)->only(['index', 'create', 'show', 'destroy']);
        Route::post('/data-peserta/import-manual', [DataPesertaController::class, 'importManual'])->name('data-peserta.import-manual');
        Route::post('/data-peserta/import-excel', [DataPesertaController::class, 'importExcel'])->name('data-peserta.import-excel');

        Route::resource('discount', DiscountController::class);
        Route::post('/discount/apply', [DiscountController::class, 'applyDiscount'])->name('discount.apply');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

        Route::resource('news', NewsController::class);

        Route::resource('rating', RatingController::class)->only(['index', 'destroy']);

        Route::get('/setting', [SettingController::class, 'admin'])->name('setting');
    });
});
