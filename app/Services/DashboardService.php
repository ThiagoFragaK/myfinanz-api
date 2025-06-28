<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\VBalance;

class DashboardService
{
    public function getBalance()
    {
        $userId = 1;
        return VBalance::selectRaw('
            month,
            user_id,
            SUM(total_income) as total_income,
            SUM(total_expense) as total_expense,
            SUM(total_income - total_expense) as net_balance
        ')
        ->where('user_id', $userId)
        ->where('month', now()->startOfMonth())
        ->groupBy('month', 'user_id')
        ->orderByDesc('month')
        ->get();
    }

    public function getTotalSavings()
    {
        return 10000;
    }

    public function getExpenses()
    {
        return VBalance::whereNotNull('card_id')
        ->where('month', Carbon::now()->startOfMonth())
        ->orderByDesc('month')
        ->get();
    }
}