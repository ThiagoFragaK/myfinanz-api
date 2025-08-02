<?php

namespace App\Services;
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
        return Expenses::with('cards')->select('id', 'name', 'description', 'created_at', 'card_id', 'parcel_numbers', 'value')->orderBy("created_at", "desc")->get();
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
            'created_at' => $date === null ? now() : $date,
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
            'created_at' => $date
        ]);

        return $this->ParcelsService->editParcelsFromExpense(
            $id,
            $parcelNumbers,
            $value,
            $cardId
        );
    }
}