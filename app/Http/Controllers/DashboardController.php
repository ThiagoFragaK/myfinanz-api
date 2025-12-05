<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    private $Service;
    public function __construct()
    {
        $this->Service = new DashboardService();
    }
    
    public function getBalance(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Balance retrieved successfully',
            'data' => $this->Service->getBalance($request->user()->id)
        ], 200);
    }

    public function getTotalSavings(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Total savings retrieved successfully',
            'data' => $this->Service->getTotalSavings($request->user()->id)
        ], 200);
    }

    public function getExpenses(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Total expenses retrieved successfully',
            'data' => $this->Service->getExpenses($request->user()->id)
        ], 200);
    }

    public function getMonthlyStats(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Monthly statistics retrieved successfully',
            'data' => $this->Service->getMonthlyStats($request->user()->id)
        ], 200);
    }

    public function getCategoriesStats(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Categories statistics retrieved successfully',
            'data' => $this->Service->getCategoriesStats($request->user()->id)
        ], 200);
    }

    public function getSavingsStats(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Savings statistics retrieved successfully',
            'data' => $this->Service->getSavingsStats($request->user()->id)
        ], 200);
    }
}