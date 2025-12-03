<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\IncomeSourcesController;
use App\Http\Controllers\IncomeTypesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PaymentMethodsController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\AuthenticationController;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(UsersController::class)
    ->prefix('users')->group(
        function () {
            Route::get('/', 'get');
            Route::get('/list', 'getList');
            Route::get('/{id}', 'getUserById');
            Route::post('/', 'store');
            Route::put('/{id}', 'edit');
            Route::delete('/{id}', 'delete');
        }
    );

Route::controller(DashboardController::class)
    ->prefix('dashboard')->group(
        function () 
        {
            Route::get('/balance', 'getBalance');
            Route::get('/savings', 'getTotalSavings');
            Route::get('/expenses', 'getExpenses');
            Route::prefix('graph')->group(function () {
                Route::get('/monthly', 'getMonthlyStats');
                Route::get('/categories', 'getCategoriesStats');
                Route::get('/savings', 'getSavingsStats');
            });
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
            Route::get('/list', 'getList');
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
            Route::get('/list', 'getList');
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

Route::controller(PaymentMethodsController::class)
    ->prefix('payment_methods')->group(
        function () 
        {
            Route::get('/', 'get');
            Route::get('/list', 'getList');
            Route::get('/{id}', 'getPaymentMethodById');
            Route::post('/', 'store');
            Route::put('/{id}', 'edit');
            Route::patch('/disable/{id}', 'disablePaymentMethod');
            Route::patch('/enable/{id}', 'enablePaymentMethod');
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

    Route::controller(CategoriesController::class)
    ->prefix('categories')->group(
        function () 
        {
            Route::get('/', 'get');
            Route::get('/list', 'getList');
            Route::get('/{id}', 'getCategoryById');
            Route::post('/', 'store');
            Route::put('/{id}', 'edit');
            Route::delete('/', 'delete');
        }
    );
