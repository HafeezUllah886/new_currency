<?php

use App\Http\Controllers\BalanceSheetReportController;
use App\Http\Controllers\dailycashbookController;
use App\Http\Controllers\ledgerReportController;
use App\Http\Controllers\profitController;
use App\Http\Controllers\DailyProductSalesReportController;
use App\Http\Controllers\TopSellingProductsReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/reports/ledger', [ledgerReportController::class, 'index'])->name('reportLedger');
    Route::get('/reports/ledger/{from}/{to}/{type}', [ledgerReportController::class, 'data'])->name('reportLedgerData');

    Route::get('/reports/balancesheet', [BalanceSheetReportController::class, 'index'])->name('reportBalanceSheet');
    Route::get('/reports/balancesheet/{type}', [BalanceSheetReportController::class, 'data'])->name('reportBalanceSheetData');


});
