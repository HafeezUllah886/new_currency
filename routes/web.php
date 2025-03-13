<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\DepositWithdrawController;
use App\Http\Middleware\confirmPassword;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';
require __DIR__ . '/finance.php';
require __DIR__ . '/reports.php';
require __DIR__ . '/todo.php';
require __DIR__ . '/ajaxRequests.php';

Route::middleware('auth')->group(function () {

    Route::get('/', [DepositWithdrawController::class, 'index'])->name('dashboard');
    Route::get('deposits/{date}', [DepositWithdrawController::class, 'deposits']);
    Route::get('withdraws/{date}', [DepositWithdrawController::class, 'withdraws']);
    Route::post('depositwithdraw/update', [DepositWithdrawController::class, 'update']);

    Route::get('/accountbalance/{id}', function ($id) {
        $result = getAccountBalance($id);

        return response()->json(['data' => $result]);
    });

    Route::get('/todaytotal/{date}', function ($date) {
        $result = todaytotal($date);
        $PKR = $result['PKR'];
        $Dollar = $result['Dollar'];

        return response()->json(['PKR' => number_format($PKR), 'Dollar' => number_format($Dollar)]);
    });
    Route::get('/totalbalance', function () {
        $result = totalbalance();
        $PKR = $result['PKR'];
        $Dollar = $result['Dollar'];

        return response()->json(['PKR' => number_format($PKR), 'Dollar' => number_format($Dollar)]);
    });

});


