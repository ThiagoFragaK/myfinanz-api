<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\IncomeSourcesService;
class IncomeSourcesController extends Controller
{
    private $Service;
    public function __construct()
    {
        $this->Service = new IncomeSourcesService();
    }

    public function get()
    {
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $this->Service->getList()
        ], 200);
    }
    
    public function getIncomeSourceById(Int $id) 
    {
        return response()->json([
            'success' => true,
            'message' => "Income Source retrieved successfully",
            'data' => $this->Service->getIncomeSourceById($id)
        ], 200);
    }

    public function store(Request $request)
    {
        $response = $this->Service->createIncomeSource([
            "name" => $request->get("name"),
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
        $incomeSource = $this->Service->editIncomeSource(
            $id,
            $request->get("name"),
        );
        
        if(isset($income['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to find the Income Source",
                'errors' => $income['errors']
            ], $income['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Income Source retrieved successfully",
            'data' => $incomeSource
        ], 200);
    }

    public function disableSource(Int $id)
    {
        $response =  $this->Service->disableSource($id);
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to disable Income",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Income Source disabled successfully",
            'data' => $response
        ], 201);
    }

    public function enableSource(Int $id)
    {
        $response = $this->Service->enableSource($id);
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to enable Income Source",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Income Source enabled successfully",
            'data' => $response
        ], 201);
    }
}
