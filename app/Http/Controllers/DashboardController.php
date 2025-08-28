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
    
    public function getBalance()
    {
        return response()->json([
            'success' => true,
            'message' => 'Balance retrieved successfully',
            'data' => $this->Service->getBalance()
        ], 200);
    }

    public function getTotalSavings()
    {
        return response()->json([
            'success' => true,
            'message' => 'Total savings retrieved successfully',
            'data' => $this->Service->getTotalSavings()
        ], 200);
    }

    public function getExpenses()
    {
        return response()->json([
            'success' => true,
            'message' => 'Total expenses retrieved successfully',
            'data' => $this->Service->getExpenses()
        ], 200);
    }

    public function getMonthlyStats()
    {
        return response()->json([
            'success' => true,
            'message' => 'Monthly statistics retrieved successfully',
            'data' => $this->Service->getMonthlyStats()
        ], 200);
    }

    public function getCategoriesStats()
    {
        return response()->json([
            'success' => true,
            'message' => 'Categories statistics retrieved successfully',
            'data' => $this->Service->getCategoriesStats()
        ], 200);
    }

    public function getSavingsStats()
    {
        return response()->json([
            'success' => true,
            'message' => 'Savings statistics retrieved successfully',
            'data' => $this->Service->getSavingsStats()
        ], 200);
    }
}