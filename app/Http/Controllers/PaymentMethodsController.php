<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PaymentMethodsService;

class PaymentMethodsController extends Controller
{
    private $Service;
    public function __construct()
    {
        $this->Service = new PaymentMethodsService();
    }

    public function get()
    {
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $this->Service->getList()
        ], 200);
    }

    public function getList()
    {
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $this->Service->getMethodsList()
        ], 200);
    }

    public function getPaymentMethodById(Int $id)
    {
        return response()->json([
            'success' => true,
            'message' => "Payment method retrieved successfully",
            'data' => $this->Service->getPaymentMethodById($id)
        ], 200);
    }

    public function store(Request $request)
    {
        $response = $this->Service->createPaymentMethod(
            $request->get("name"),
            $request->get("type"),
            $request->get("turn_day"),
            $request->get("limit"),
        );
        
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to create Payment method",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Payment method created successfully",
            'data' => $response
        ], 201);
    }

    public function edit(Int $id, Request $request)
    {
        $payment = $this->Service->editPaymentMethod(
            $id,
            $request->get("name"),
            $request->get("type"),
            $request->get("turn_day"),
            $request->get("limit"),
        );
        
        if(isset($income['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to edit the Payment method",
                'errors' => $income['errors']
            ], $income['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Payment method retrieved successfully",
            'data' => $payment
        ], 200);
    }

    public function disablePaymentMethod(Int $id)
    {
        $response =  $this->Service->disablePaymentMethod($id);
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to disable Payment method",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Payment method disabled successfully",
            'data' => $response
        ], 201);
    }

    public function enablePaymentMethod(Int $id)
    {
        $response = $this->Service->enablePaymentMethod($id);
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to enable Payment method",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Payment method enable successfully",
            'data' => $response
        ], 201);
    }
}