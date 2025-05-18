<?php

namespace App\Services;
use App\Enums\StatusEnum;
use App\Models\IncomeSources;
class IncomeSourcesService
{
    public function getList()
    {
        return IncomeSources::whereActive()->select('id', 'name', 'status')->get();
    }

    public function getIncomeSourceById(Int $id)
    {
        return IncomeSources::find($id);
    }

    public function createIncomeSource(Array $incomeSource)
    {
        return IncomeSources::create($incomeSource);
    }

    public function editIncomeSource(Int $id, String $name)
    {
        $incomeSource = $this->getIncomeSourceById($id);
        if(is_null($incomeSource))
        {
            return [
                'errors' => "Failed to retrieve Income Source",
                'http' => 400
            ];
        }

        return $incomeSource->update([
            "name" => $name
        ]);
    }

    public function enableSource(Int $id)
    {
        $income = $this->getIncomeSourceById($id);
        if(is_null($income))
        {
            return [
                'errors' => "Failed to retrieve Income Source",
                'http' => 404
            ];
        }

        $income->update([
            "status" => StatusEnum::Active->value,
        ]);
    }

    public function disableSource(Int $id)
    {
        $income = $this->getIncomeSourceById($id);
        if(is_null($income))
        {
            return [
                'errors' => "Failed to retrieve Income Source",
                'http' => 404
            ];
        }

        return $income->update([
            "status" => StatusEnum::Inactive->value,
        ]);
    }
}
