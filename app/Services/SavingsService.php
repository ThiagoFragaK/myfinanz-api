<?php

namespace App\Services;
use App\Models\Savings;
use Illuminate\Database\Eloquent\Builder;
class SavingsService
{
    public function getList(Int $userId, Array|Null $filters)
    {
        $savings = Savings::where('user_id', $userId)->select('value', 'is_positive')->get();
        $sum = $this->sumSavings($savings);

        $savingsList = Savings::where('user_id', $userId)->select('id', 'value', 'is_positive', 'created_at');
        $savingsList = $this->filterList($savingsList, $filters);

        return [
            'list' => $savingsList->orderBy('created_at', 'desc')->paginate(10),
            'sum' => number_format($sum, 2, '.', ''),
        ];
    }

    private function filterList(Builder $list, Array|Null $filters)
    {
        if(isset($filters["date"]))
        {
            $dates = $filters["date"];
            if(isset($dates["min"]))
            {
                $list->where('created_at', '>=', $dates['min']);
            }
            if(isset($dates["max"]))
            {
                $list->where('created_at', '<=', $dates['max']);
            }
        }

        if(isset($filters["value"]))
        {
            $values = $filters["value"];
            if(isset($values["min"]))
            {
                $list->where("value", "<=", $values["min"]);
            }
            if(isset($values["max"]))
            {
                $list->where("value", "<=", $values["max"]);
            }
        }
        return $list;
    }

    public function getSavingById(int $id)
    {
        return Savings::find($id);
    }

    public function createSaving(Int $userId, Float $value, Bool $isPositive)
    {
        return Savings::create([
            'value' => $value,
            'is_positive' => $isPositive,
            'user_id' => $userId,
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
