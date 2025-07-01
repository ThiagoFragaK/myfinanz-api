<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\VBalance;
use App\Models\Expenses;
use App\Models\Savings;

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
        ->first();
    }

    public function getTotalSavings()
    {
        $currentTotal = Savings::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])
        ->get()
        ->reduce(function ($carry, $saving) {
            return $carry + ($saving->is_positive ? $saving->value : -$saving->value);
        }, 0);

        $previousTotal = Savings::whereBetween('created_at', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth(),
            ])
            ->get()
            ->reduce(function ($carry, $saving) {
                return $carry + ($saving->is_positive ? $saving->value : -$saving->value);
            }, 0);

        $variation = $previousTotal != 0
            ? round((($currentTotal - $previousTotal) / $previousTotal) * 100, 2)
            : null;

        return [
            "current" => $currentTotal,
            "previous" => $previousTotal,
            "variation" => $variation,
        ];
    }

    public function getExpenses()
    {
        return Expenses::select("name", "created_at", "value")
        ->where('created_at', '>=', Carbon::now()->subDays(14))
        ->orderByDesc('created_at')
        ->get();
    }
}