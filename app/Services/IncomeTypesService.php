<?php

namespace App\Services;
use App\Models\IncomeTypes;
class IncomeTypesService
{
    public function getList()
    {
        return IncomeTypes::select('id', 'name')->get();
    }

    public function createIncomeType()
    {

    }

    public function editIncomeType()
    {

    }
}