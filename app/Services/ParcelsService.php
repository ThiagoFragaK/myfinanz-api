<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Parcels;

class ParcelsService
{
    public function createParcelsFromExpense(Int $expenseId, Int $parcelNumber, Float $value, Int $paymentMethodId)
    {
        $parcels = Parcels::where('expense_id', $expenseId)->first();
        if(!is_null($parcels))
        {
            return [
                'errors' => "There're already parcels for this expense, enabled to create. Edit it instead.",
                'http' => 404
            ];
        }

        $parcelList = $this->generateParcels($expenseId, $parcelNumber, $value, $paymentMethodId);
        return Parcels::insert($parcelList);
    }

    public function editParcelsFromExpense(Int $expenseId, Int $parcelNumber, Float $value, Int $paymentMethodId)
    {
        return DB::transaction(function () use ($expenseId, $parcelNumber, $value, $paymentMethodId) {
            Parcels::where('expense_id', $expenseId)->delete();
            $parcelList = $this->generateParcels($expenseId, $parcelNumber, $value, $paymentMethodId);
            return Parcels::insert($parcelList);
        });
    }

    private function generateParcels(Int $expenseId, Int $parcelNumber, Float $value, Int $paymentMethodId)
    {
        $parcellist = [];
        $now = Carbon::now();
        $valueByParcel = $value / $parcelNumber;
        for($i = 1; $i < $parcelNumber + 1; $i++)
        {
            $parcellist[] = [
                'expense_id' => $expenseId,
                'payment_method_id' => $paymentMethodId,
                'value' => $valueByParcel,
                'date' => $now->copy()->addMonths($i),
                'parcel' => $i,
                'created_at' => now()
            ];
        }
        return $parcellist;
    }
}