<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\IncomeTypesService;

class IncomeTypesController extends Controller
{
    private $Service;
    public function __construct()
    {
        $this->Service = new IncomeTypesService();
    }

    public function get()
    {
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $this->Service->getList()
        ], 200);
    }

    public function getIncomeTypeById(Int $id)
    {
        return response()->json([
            'success' => true,
            'message' => "Income Type retrieved successfully",
            'data' => $this->Service->getIncomeTypeById($id)
        ], 200);
    }

    public function store(Request $request)
    {
        $response = $this->Service->createIncomeType([
            "name" => $request->get("name"),
            "created_at" => now(),
        ]);

        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to create Income Type",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Income Type created successfully",
            'data' => $response
        ], 201);
    }

    public function edit(Int $id, Request $request)
    {
        $incomeType = $this->Service->editIncomeType(
            $id,
            $request->get("name"),
        );
        
        if(isset($income['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to find the Income",
                'errors' => $income['errors']
            ], $income['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Income retrieved successfully",
            'data' => $incomeType
        ], 200);
    }
}
