<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\VBalance;
use App\Models\Expenses;
use App\Models\Incomes;
use App\Models\Savings;

class DashboardService
{
    public function getBalance()
    {
        $expenses = $this->getExpenses()->sum("value");
        $incomes = Incomes::select("value", "created_at")
            ->where("user_id", 1)
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->sum("value");

        return [
            "net_balance" => $incomes - $expenses,
            "total_expense" => $expenses,
            "total_income" => $incomes,
        ];
    }

    public function getExpenses()
    {
        return Expenses::select("name", "created_at", "value")
        ->where('created_at', '>=', Carbon::now()->subDays(14))
        ->orderByDesc('created_at')
        ->get();
    }

    public function getTotalSavings()
    {
        $currentTotal = Savings::get()
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

        if ($currentTotal === 0) {
            return [
                'current' => $previousTotal,
                'previous' => $previousTotal,
                'variation' => 0,
            ];
        }

        $variation = $previousTotal != 0
            ? round((($currentTotal - $previousTotal) / $previousTotal) * 100, 2)
            : null;

        return [
            'current' => $currentTotal,
            'previous' => $previousTotal,
            'variation' => $variation,
        ];
    }
}