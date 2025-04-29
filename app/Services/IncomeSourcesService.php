<?php

namespace App\Services;
use App\Models\IncomeSources;
class IncomeSourcesService
{
    public function getList()
    {
        return IncomeSources::whereActive()->select('id', 'name')->get();
    }

    public function createIncomeSource()
    {

    }

    public function editIncomeSource() 
    {

    }

    public function enableIncomeSource()
    {

    }

    public function disableIncomeSource()
    {

    }
}