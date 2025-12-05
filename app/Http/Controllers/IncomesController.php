<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Incomes;
use App\Services\IncomesService;

class IncomesController extends Controller
{
    private $Service;
    public function __construct()
    {
        $this->Service = new IncomesService();
    }

    public function get(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $this->Service->getList($request->user()->id)
        ], 200);
    }

    public function getIncomeById(Int $id)
    {
        return response()->json([
            'success' => true,
            'message' => "Income retrieved successfully",
            'data' => $this->Service->getIncomeById($id)
        ], 200);
    }

    public function store(Request $request)
    {
        $response = $this->Service->createIncome(
            $request->user()->id,
            $request->get('name'),
            $request->get('value'),
            $request->get('entry_day'),
            $request->get('source_id'),
            $request->get('type_id'),
        );

        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to create Income",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Income created successfully",
            'data' => $response
        ], 201);
    }

    public function edit(Int $id, Request $request)
    {
        $income = $this->Service->editIncome(
            $id,
            $request->get('name'),
            $request->get('value'),
            $request->get('entry_day'),
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
            'data' => $income
        ], 200);
    }

    public function disableIncome(Int $id)
    {
        $response =  $this->Service->disableIncome($id);
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
            'message' => "Income created successfully",
            'data' => $response
        ], 201);
    }

    public function enableIncome(Int $id)
    {
        $response = $this->Service->enableIncome($id);
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to enable Income",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Income created successfully",
            'data' => $response
        ], 201);
    }
}
