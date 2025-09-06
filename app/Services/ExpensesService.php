<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Expenses;
use App\Services\PaymentMethodsService;
use App\Services\ParcelsService;
use Illuminate\Database\Eloquent\Builder;
class ExpensesService
{
    private $PaymentMethodsService;
    private $ParcelsService;
    public function __construct()
    {
        $this->PaymentMethodsService = new PaymentMethodsService();
        $this->ParcelsService = new ParcelsService();
    }

    public function getList(Array|Null $filters)
    {
        $expenses = Expenses::with(['paymentMethods', 'categories'])
            ->select('id', 'name', 'description', 'date', 'payment_methods_id', 'category_id', 'parcel_numbers', 'value');
        $expenses = $this->filterList($expenses, $filters);
        return $expenses->orderBy("date", "desc")->get();
    }

    private function filterList(Builder $list, Array|Null $filters): Builder
    {
        if(isset($filters["name"]))
        {
            $list->where("name", 'like', "%".$filters["name"]."%");
        }

        if(isset($filters["category_id"]))
        {
            $list->where("category_id", $filters["category_id"]);
        }
        
        if(isset($filters["payment_methods_id"]))
        {
            $list->where("payment_methods_id", $filters["payment_methods_id"]);
        }
        
        if(isset($filters["valuesMax"]))
        {
            $list->where("value", "<=", $filters["valuesMax"]);
        }

        if($filters["isCurrentMonth"] == "true")
        {
            $list->whereBetween('date', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ]);            
        }
        return $list;
    }

    public function getExpenseById(int $id)
    {
        return Expenses::find($id);
    }

    public function createExpense(String $name, String $description, Int $paymentMethodId, Int|Null $categoryId, Int $parcelNumber, Float $value, String|Null $date)
    {
        $paymentMethod = $this->PaymentMethodsService->getPaymentMethodById($paymentMethodId);
        if(is_null($paymentMethod))
        {
            return [
                'errors' => "Failed to retrieve Payment method",
                'http' => 412
            ];
        }
        
        $expenseId = Expenses::create([
            'name' => $name,
            'description' => $description,
            'payment_methods_id' => $paymentMethodId,
            'category_id' => $categoryId,
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
            $paymentMethodId
        );
    }

    public function editExpense(Int $id, String $name, String $description, Int $paymentMethodId, Int|Null $categoryId, Int $parcelNumbers, Float $value, String|Null $date)
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
            'payment_methods_id' => $paymentMethodId,
            'category_id' => $categoryId,
            'parcel_numbers' => $parcelNumbers,
            'value' => $value,
            'date' => $date,
            'updated_at' => now(),
        ]);

        return $this->ParcelsService->editParcelsFromExpense(
            $id,
            $parcelNumbers,
            $value,
            $paymentMethodId
        );
    }
}