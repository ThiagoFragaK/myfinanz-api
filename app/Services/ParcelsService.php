<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Parcels;

class ParcelsService
{
    public function createParcelsFromExpense(Int $expenseId, Int $parcelNumber, Float $value, Int $cardId)
    {
        $parcels = Parcels::where('expense_id', $expenseId)->first();
        if(!is_null($parcels))
        {
            return [
                'errors' => "There're already parcels for this expense, enabled to create. Edit it instead.",
                'http' => 404
            ];
        }

        $parcellist = $this->generateParcels($expenseId, $parcelNumber, $value, $cardId);
        return Parcels::insert($parcellist);
    }

    public function editParcelsFromExpense(Int $expenseId, Int $parcelNumber, Float $value, Int $cardId)
    {
        return DB::transaction(function () use ($expenseId, $parcelNumber, $value, $cardId) {
            Parcels::where('expense_id', $expenseId)->delete();
            $parcelList = $this->generateParcels($expenseId, $parcelNumber, $value, $cardId);
            return Parcels::insert($parcelList);
        });
    }

    private function generateParcels(Int $expenseId, Int $parcelNumber, Float $value, Int $cardId)
    {
        $parcellist = [];
        $now = Carbon::now();
        $valueByParcel = $value / $parcelNumber;
        for($i = 1; $i < $parcelNumber + 1; $i++)
        {
            $parcellist[] = [
                'expense_id' => $expenseId,
                'card_id' => $cardId,
                'value' => $valueByParcel,
                'date' => $now->copy()->addMonths($i),
                'parcel' => $i,
            ];
        }
        return $parcellist;
    }
}