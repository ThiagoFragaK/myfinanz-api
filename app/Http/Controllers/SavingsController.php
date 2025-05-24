<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Savings;
use App\Http\Controllers\Controller;
use App\Services\SavingsService;

class SavingsController extends Controller
{
    private $Service;
    public function __construct()
    {
        $this->Service = new SavingsService();
    }

    public function get()
    {
        $savings = $this->Service->getList();
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $savings['list'],
            'sum' => $savings['sum']
        ], 200);
    }

    public function getSavingById(Int $id)
    {
        return response()->json([
            'success' => true,
            'message' => "Saving retrieved successfully",
            'data' => $this->Service->getSavingById($id)
        ], 200);
    }

    public function store(Request $request)
    {
        $response = $this->Service->createSaving(
            $request->get("value"),
            $request->get("is_positive"),
        );
        
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to create Saving",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Saving created successfully",
            'data' => $response
        ], 201);
    }

    public function edit(Int $id, Request $request)
    {
        $payment = $this->Service->editSaving(
            $id,
            $request->get("value"),
            $request->get("is_positive"),
        );
        
        if(isset($income['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to find the Saving",
                'errors' => $income['errors']
            ], $income['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Saving retrieved successfully",
            'data' => $payment
        ], 200);
    }
}