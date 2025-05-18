<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Http\Controllers\Controller;
use App\Services\ExpensesService;

class ExpensesController extends Controller
{
    private $Service;
    public function __construct()
    {
        $this->Service = new ExpensesService();
    }

    public function get()
    {
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $this->Service->getList()
        ], 200);
    }

    public function getExpenseById(Int $id)
    {
        return response()->json([
            'success' => true,
            'message' => "Expense retrieved successfully",
            'data' => $this->Service->getExpenseById($id)
        ], 200);
    }

    public function store(Request $request)
    {
        $response = $this->Service->createExpense(
            $request->get("name"),
            $request->get("description"),
            $request->get("card_id"),
            $request->get("parcel_number"),
            $request->get("value"),
        );
        
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to create Expense",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Expense created successfully",
            'data' => $response
        ], 201);
    }

    public function edit(Int $id, Request $request)
    {
        $payment = $this->Service->editExpense(
            $id,
            $request->get("name"),
            $request->get("description"),
            $request->get("card_id"),
            $request->get("parcel_number"),
            $request->get("value"),
        );
        
        if(isset($income['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to edit the Expense",
                'errors' => $income['errors']
            ], $income['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Expense retrieved successfully",
            'data' => $payment
        ], 200);
    }
}
