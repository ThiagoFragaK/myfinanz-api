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
        IncomeTypes::create($incomeType);
        return true;
    }

    public function editIncomeType(Int $id, String $name)
    {
        $type = $this->getIncomeTypeById($id);
        $type->update([
            "name" => $name,
        ]);

        return true;
    }
}
