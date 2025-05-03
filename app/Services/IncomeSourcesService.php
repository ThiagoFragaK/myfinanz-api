<?php

namespace App\Services;
use App\Enums\StatusEnum;
use App\Models\IncomeSources;
class IncomeSourcesService
{
    public function getList()
    {
        return IncomeSources::whereActive()->select('id', 'name')->get();
    }

    public function getIncomeSourceById(Int $id)
    {
        return IncomeSources::find($id);
    }

    public function createIncomeSource(Array $incomeSource)
    {
        IncomeSources::create($incomeSource);
        return true;
    }

    public function editIncomeSource(Int $id, String $name)
    {
        $incomeSource = $this->getIncomeSourceById($id);
        $incomeSource->update([
            "name" => $name
        ]);

        return true;
    }

    public function removeIncomeSource(Int $id)
    {
        $incomeSource = $this->getIncomeSourceById($id);
        if($incomeSource->status === StatusEnum::Active->value)
        {
            return $this->disableIncomeSource($id, $incomeSource);
        }
        else
        {
            return $this->enableIncomeSource($id, $incomeSource);
        }
    }

    public function enableIncomeSource(Int $id, $incomeSource)
    {

    }

    public function disableIncomeSource(Int $id, $incomeSource)
    {

    }
}
