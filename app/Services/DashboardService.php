<?php

namespace App\Services;

use Carbon\Carbon;
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
        return Expenses::select("name", "date", "value")
        ->whereBetween('date', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])
        ->orderByDesc('date')
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

    public function getMonthlyStats()
    {
        $incomesRaw = Incomes::select('value', 'created_at', 'user_id')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->get();

        $expensesRaw = Expenses::select('value', 'created_at', 'user_id')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->get();

        $savingsRaw = Savings::select('value', 'is_positive', 'created_at', 'user_id')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->get();

        $monthlyStats = $this->groupByMonth($incomesRaw, $expensesRaw, $savingsRaw);
        return $this->formatMonthlyStats($monthlyStats);
    }

    private function groupByMonth($incomesRaw, $expensesRaw, $savingsRaw) 
    {
        $monthsList = collect(range(0, 5))
        ->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('Y-m');
        })
        ->reverse()
        ->values();

        $groupSumByMonth = function ($collection, $valueKey = 'value', $isPositiveKey = null) {
            return $collection->groupBy(function ($item) {
                return $item->created_at->format('Y-m');
            })->map(function ($items) use ($valueKey, $isPositiveKey) {
                if ($isPositiveKey !== null) {
                    return $items->reduce(function ($carry, $item) use ($valueKey, $isPositiveKey) {
                        return $carry + ($item->$isPositiveKey ? $item->$valueKey : -$item->$valueKey);
                    }, 0);
                }
                return $items->sum($valueKey);
            });
        };

        $incomes = $groupSumByMonth($incomesRaw);
        $expenses = $groupSumByMonth($expensesRaw);
        // $savings = $groupSumByMonth($savingsRaw, 'value', 'is_positive');

        $results = [];

        foreach ($monthsList as $month) {
            $income = $incomes[$month] ?? 0;
            $expense = $expenses[$month] ?? 0;
            // $saving = $savings[$month] ?? 0;
            $balance = $income - $expense;

            $results[$month] = [
                'income' => round($income, 2),
                'expense' => round($expense, 2),
                'balance' => round($balance, 2),
                // 'saving' => round($saving, 2),
            ];
        }

        return $results;
    }

    private function formatMonthlyStats($groupedData)
    {
        $months = array_keys($groupedData);
        $keys = array_keys(reset($groupedData));
        $data = array_map(function ($key) use ($months, $groupedData) {
            return [
                'name' => ucfirst($key),
                'data' => array_map(fn($month) => $groupedData[$month][$key] ?? 0, $months),
            ];
        }, $keys);

        return [
            'dates' => $months,
            'data' => $data,
        ];
    }
}