<?php

namespace App\Services;

use Carbon\Carbon;
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
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])
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
            return [
                'errors' => "Failed to retrieve Income Type",
                'http' => 400
            ];
        }

        $source = (new IncomeSourcesService())->getIncomeSourceById($sourceId);
        if(is_null($source))
        {
            return [
                'errors' => "Failed to retrieve Income Source",
                'http' => 400
            ];
        }

        return Incomes::create([
            "name" => $name,
            "value" => $value,
            "entry_day" => $entryDay,
            "source_id" => $sourceId,
            "type_id" => $typeId,
            "status" => StatusEnum::Active->value,
            "user_id" => 1
        ]);
    }

    public function editIncome(Int $id, String $name, Float $value, Int $entryDay)
    {
        $income = $this->getIncomeById($id);
        if(is_null($income))
        {
            return [
                'errors' => "Failed to retrieve Income",
                'http' => 404
            ];
        }

        return $income->update([
            "name" => $name,
            "value" => $value,
            "entry_day" => $entryDay
        ]);
    }

    public function enableIncome(Int $id)
    {
        $income = $this->getIncomeById($id);
        if(is_null($income))
        {
            return [
                'errors' => "Failed to retrieve Income",
                'http' => 404
            ];
        }

        $income->update([
            "status" => StatusEnum::Active->value,
        ]);
    }

    public function disableIncome(Int $id)
    {
        $income = $this->getIncomeById($id);
        if(is_null($income))
        {
            return [
                'errors' => "Failed to retrieve Income",
                'http' => 404
            ];
        }

        return $income->update([
            "status" => StatusEnum::Inactive->value,
        ]);
    }
}
