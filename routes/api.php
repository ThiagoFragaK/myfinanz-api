<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\IncomeSourcesController;
use App\Http\Controllers\IncomeTypesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\SavingsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(DashboardController::class)
    ->prefix('incomes')->group(
        function () 
        {
            Route::get('/balance', 'getBalance');
            Route::get('/savings', 'getTotalSavings');
            Route::get('/expenses', 'getExpenses');
        }
    );

    Route::controller(IncomesController::class)
    ->prefix('incomes')->group(
        function () 
        {
            Route::get('/', 'get');
            Route::get('/{id}', 'getIncomeById');
            Route::post('/', 'store');
            Route::put('/{id}', 'edit');
            Route::patch('disable/{id}', 'disableIncome');
            Route::patch('enable/{id}', 'enableIncome');
        }
    );

Route::controller(IncomeTypesController::class)
    ->prefix('income/types')->group(
        function () 
        {
            Route::get('/', 'get');
            Route::get('/{id}', 'getIncomeTypeById');
            Route::post('/', 'store');
            Route::put('/{id}', 'edit');
        }
    );

Route::controller(IncomeSourcesController::class)
    ->prefix('income/sources')->group(
        function () 
        {
            Route::get('/', 'get');
            Route::get('/{id}', 'getIncomeSourceById');
            Route::post('/', 'store');
            Route::put('/{id}', 'edit');
            Route::patch('disable/{id}', 'disableSource');
            Route::patch('enable/{id}', 'enableSource');
        }
    );

Route::controller(ExpensesController::class)
    ->prefix('expenses')->group(
        function () 
        {
            Route::get('/', 'get');
            Route::get('/{id}', 'getExpenseById');
            Route::post('/', 'store');
            Route::put('/{id}', 'edit');
        }
    );

Route::controller(CardsController::class)
    ->prefix('cards')->group(
        function () 
        {
            Route::get('/', 'get');
            Route::get('/{id}', 'getCardById');
            Route::post('/', 'store');
            Route::put('/{id}', 'edit');
            Route::patch('/disable/{id}', 'disableCard');
            Route::patch('/enable/{id}', 'enableCard');
        }
    );

Route::controller(PaymentsController::class)
    ->prefix('payments')->group(
        function () 
        {
            Route::get('/', 'get');
            Route::get('/status', 'getDebtsStatusByMonth');
            Route::get('/{id}', 'getPaymentById');
            Route::post('/', 'store');
            Route::put('/', 'edit');
            Route::patch('/enable/{id}', 'enablePayment');
            Route::patch('/disable/{id}', 'disablePayment');
            Route::patch('/pay/{id}', 'payDebt');
            Route::patch('/open/{id}', 'openDebt');
        }
    );

Route::controller(SavingsController::class)
    ->prefix('savings')->group(
        function () 
        {
            Route::get('/', 'get');
            Route::get('/{id}', 'getSavingById');
            Route::post('/', 'store');
            Route::put('/', 'edit');
        }
    );
