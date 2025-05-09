<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Incomes;
use App\Services\IncomeSourcesService;
use App\Services\IncomeTypesService;

class IncomesService
{
    public function getList()
    {
        return Incomes::with(["incomeSources:id,name", "types:id,name"])
            ->select("id", "name", "value", "entry_day", "source_id", "type_id", "status")
            ->get();
    }

    public function getIncomeById(Int $id)
    {
        return Incomes::find($id);
    }

    public function createIncome(String $name, Float $value, Int $entryDay, Int $sourceId, Int $typeId)
    {
        $type = (new IncomeTypesService())->getIncomeTypeById($typeId);
        if(is_null($type))
        {
            return false;
        }

        $source = (new IncomeSourcesService())->getIncomeSourceById($sourceId);
        if(is_null($source))
        {
            return false;
        }

        Incomes::create([
            "name" => $name,
            "value" => $value,
            "entry_day" => $entryDay,
            "source_id" => $sourceId,
            "type_id" => $typeId,
            "status" => StatusEnum::Active->value,
            "user_id" => 1
        ]);
        return true;
    }

    public function editIncome(Int $id, String $name, Float $value, Int $entryDay)
    {
        $income = $this->getIncomeById($id);
        $income->update([
            "name" => $name,
            "value" => $value,
            "entry_day" => $entryDay
        ]);

        return true;
    }

    public function updateIncomeStatus(Int $id)
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

    public function enableIncome(Int $id)
    {
        $income = $this->getIncomeById($id);
        $income->update([
            "status" => StatusEnum::Active->value,
        ]);

        return true;
    }

    public function disableIncome(Int $id)
    {
        $income = $this->getIncomeById($id);
        $income->update([
            "status" => StatusEnum::Inactive->value,
        ]);

        return true;
    }
}
