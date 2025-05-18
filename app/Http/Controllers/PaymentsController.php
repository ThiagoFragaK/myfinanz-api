<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payments;
use App\Http\Controllers\Controller;
use App\Services\PaymentsService;

class PaymentsController extends Controller
{
    private $Service;
    public function __construct()
    {
        $this->Service = new PaymentsService();
    }

    public function get()
    {
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $this->Service->getList()
        ], 200);
    }

    public function getPaymentById(Int $id)
    {
        return response()->json([
            'success' => true,
            'message' => "Income Source retrieved successfully",
            'data' => $this->Service->getPaymentById($id)
        ], 200);
    }

    public function store(Request $request)
    {
        $response = $this->Service->createPayment(
            $request->get("name"),
            $request->get("description"),
            $request->get("value"),
            $request->get("due_date"),
        );
        
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to create Payment",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Payment created successfully",
            'data' => $response
        ], 201);
    }

    public function edit(Int $id, Request $request)
    {
        $payment = $this->Service->editPayment(
            $id,
            $request->get("name"),
            $request->get("description"),
            $request->get("value"),
            $request->get("due_date"),
        );
        
        if(isset($income['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to find the Payment",
                'errors' => $income['errors']
            ], $income['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Payment retrieved successfully",
            'data' => $payment
        ], 200);
    }

    public function disablePayment(Int $id)
    {
        $response =  $this->Service->disablePayment($id);
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to disable Payment",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Payment disabled successfully",
            'data' => $response
        ], 201);
    }

    public function payDebt(Int $id)
    {
        $response =  $this->Service->payDebt($id);
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to update pay Debt",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Debt paid successfully",
            'data' => $response
        ], 201);
    }
}
