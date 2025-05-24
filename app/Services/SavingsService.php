<?php

namespace App\Services;
use App\Models\Savings;
class SavingsService
{
    public function getList()
    {
        $savings = Savings::select('id', 'value', 'is_positive', 'created_at')->orderBy('created_at', 'desc')->get();
        return [
            'list' => $savings,
            'sum' => $this->sumSavings($savings)
        ];
    }

    public function getSavingById(int $id)
    {
        return Savings::find($id);
    }

    public function createSaving(Float $value, Bool $isPositive)
    {
        return Savings::create([
            'value' => $value,
            'is_positive' => $isPositive,
            'user_id' => 1,
        ]);
    }

    public function editSaving(Int $id, Float $value, Bool $isPositive)
    {
        $saving = $this->getSavingById($id);
        if(is_null($saving))
        {
            return [
                'errors' => "Failed to retrieve Saving",
                'http' => 404
            ];
        }

        return $saving->update([
            "value" => $value,
            "is_positive" => $isPositive,
        ]);
    }

    private function sumSavings($savings)
    {
        return $savings->reduce(function ($sum, $item) {
            return $sum + ($item->is_positive ? $item->value : -$item->value);
        }, 0);
    }
}
