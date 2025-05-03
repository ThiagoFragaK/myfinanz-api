<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Incomes;

class IncomesService
{
    public function getList()
    {
        return Incomes::select("id", "name")->get();
    }

    public function getIncomeById(Int $id)
    {
        return Incomes::find($id);
    }

    public function createIncome(Array $incomeSource)
    {
        Incomes::create($incomeSource);
        return true;
    }

    public function editIncome(Int $id, String $name)
    {
        $income = $this->getIncomeById($id);
        $income->update([
            "name" => $name
        ]);

        return true;
    }

    public function removeIncome(Int $id)
    {
        $income = $this->getIncomeById($id);
        if($income->status === StatusEnum::Active->value)
        {
            return $this->disableIncome($id, $income);
        }
        else
        {
            return $this->enableIncome($id, $income);
        }
    }

    private function enableIncome(Int $id, $income)
    {
        $income->update([
            "status" => StatusEnum::Active->value,
        ]);

        return true;
    }

    private function disableIncome(Int $id, $income)
    {
        $income->update([
            "status" => StatusEnum::Inactive->value,
        ]);

        return true;
    }
}
