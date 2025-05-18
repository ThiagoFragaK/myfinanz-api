<?php

namespace App\Services;
use App\Models\Savings;
class SavingsService
{
    public function getList()
    {
        return Savings::select('id', 'value', 'is_positive',)->get();
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
}
