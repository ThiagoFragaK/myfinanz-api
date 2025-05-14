<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardsController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\IncomeSourcesController;
use App\Http\Controllers\IncomeTypesController;
use App\Http\Controllers\ParcelsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\SavingsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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
            Route::post('/', 'store');
            Route::put('/{id}', 'edit');
        }
    );

// Route::controller(ExpensesController::class)
//     ->prefix('expenses')->group(
//         function () 
//         {
//             Route::get('/', 'get');
//         }
//     );

// Route::controller(CardsController::class)
//     ->prefix('cards')->group(
//         function () 
//         {
//             Route::get('/', 'get');
//         }
//     );

// Route::controller(ParcelsController::class)
//     ->prefix('parcels')->group(
//         function () 
//         {
//             Route::get('/', 'get');
//         }
//     );

// Route::controller(PaymentsController::class)
//     ->prefix('payments')->group(
//         function () 
//         {
//             Route::get('/', 'get');
//         }
//     );

// Route::controller(SavingsController::class)
//     ->prefix('savings')->group(
//         function () 
//         {
//             Route::get('/', 'get');
//         }
//     );
