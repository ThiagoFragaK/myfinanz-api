<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Expenses;
use App\Services\CardsService;
use App\Services\ParcelsService;
class ExpensesService
{
    private $CardsService;
    private $ParcelsService;
    public function __construct()
    {
        $this->CardsService = new CardsService();
        $this->ParcelsService = new ParcelsService();
    }

    public function getList()
    {
        return Expenses::with('cards')
            ->select('id', 'name', 'description', 'date', 'card_id', 'parcel_numbers', 'value')
            ->orderBy("date", "desc")
            ->whereBetween('date', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])
            ->get();
    }

    public function getExpenseById(int $id)
    {
        return Expenses::find($id);
    }

    public function createExpense(String $name, String $description, Int $cardId, Int $parcelNumber, Float $value, String|Null $date)
    {
        $card = $this->CardsService->getCardById($cardId);
        if(is_null($card))
        {
            return [
                'errors' => "Failed to retrieve Card",
                'http' => 412
            ];
        }
        
        $expenseId = Expenses::create([
            'name' => $name,
            'description' => $description,
            'card_id' => $cardId,
            'parcel_numbers' => $parcelNumber,
            'value' => $value,
            'user_id' => 1,
            'date' => $date === null ? now() : $date,
            'created_at' => now(),
        ])->id;

        return $this->ParcelsService->createParcelsFromExpense(
            $expenseId,
            $parcelNumber,
            $value,
            $cardId
        );
    }

    public function editExpense(Int $id, String $name, String $description, Int $cardId, Int $parcelNumbers, Float $value, String|Null $date)
    {
        $expense = $this->getExpenseById($id);
        if(is_null($expense))
        {
            return [
                'errors' => "Failed to retrieve Expense",
                'http' => 404
            ];
        }
        
        $expense->update([
            'name' => $name,
            'description' => $description,
            'card_id' => $cardId,
            'parcel_numbers' => $parcelNumbers,
            'value' => $value,
            'date' => $date,
            'updated_at' => now(),
        ]);

        return $this->ParcelsService->editParcelsFromExpense(
            $id,
            $parcelNumbers,
            $value,
            $cardId
        );
    }
}