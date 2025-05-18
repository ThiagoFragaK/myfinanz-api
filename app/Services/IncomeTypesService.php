<?php

namespace App\Services;
use App\Models\IncomeTypes;
class IncomeTypesService
{
    public function getList()
    {
        return IncomeTypes::select('id', 'name')->get();
    }

    public function getIncomeTypeById(int $id)
    {
        return IncomeTypes::find($id);
    }

    public function createIncomeType(Array $incomeType)
    {
        return IncomeTypes::create($incomeType);
    }

    public function editIncomeType(Int $id, String $name)
    {
        $type = $this->getIncomeTypeById($id);
        if(is_null($type))
        {
            return [
                'errors' => "Failed to retrieve Income Type",
                'http' => 404
            ];
        }

        return $type->update([
            "name" => $name,
        ]);
    }
}
