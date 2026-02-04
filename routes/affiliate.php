<?php

use App\Http\Controllers\DashboardAffiliate\MainController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:affiliate'])->group(function () {
    Route::get('dashboard-affiliate/beranda', [MainController::class, 'index'])->name('affiliate.index');

});
