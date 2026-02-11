<?php

use App\Http\Controllers\DashboardAffiliate\MainController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:affiliate'])->group(function () {
    Route::get('dashboard-affiliate/beranda', [MainController::class, 'index'])->name('affiliate.index');
    Route::get('dashboard-affiliate/laporan', [MainController::class, 'laporan'])->name('affiliate.laporan');
    Route::get('dashboard-affiliate/penarikan', [MainController::class, 'penarikan'])->name('affiliate.penarikan');
    Route::get('dashboard-affiliate/referral', [MainController::class, 'referral'])->name('affiliate.referral');
    Route::get('dashboard-affiliate/tools', [MainController::class, 'tools'])->name('affiliate.tools');
    Route::get('dashboard-affiliate/panduan', [MainController::class, 'panduan'])->name('affiliate.panduan');
});
