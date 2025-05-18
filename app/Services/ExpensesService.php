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
        return Expenses::select('id', 'name', 'description', 'card_id', 'parcel_number', 'value')->get();
    }

    public function getExpenseById(int $id)
    {
        return Expenses::find($id);
    }

    public function createExpense(String $name, String $description, Int $cardId, Int $parcelNumber, Float $value)
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
            'parcel_number' => $parcelNumber,
            'value' => $value,
        ])->id;

        return $this->ParcelsService->createParcelsFromExpense(
            $expenseId,
            $parcelNumber,
            $value,
            $cardId
        );
    }

    public function editExpense(Int $id, String $name, String $description, Int $cardId, Int $parcelNumber, Float $value)
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
            'parcel_number' => $parcelNumber,
            'value' => $value,
        ]);

        return $this->ParcelsService->editParcelsFromExpense(
            $id,
            $parcelNumber,
            $value,
            $cardId
        );
    }
}