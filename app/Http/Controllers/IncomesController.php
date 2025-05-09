<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Incomes;
use App\Services\IncomesService;

class IncomesController extends Controller
{
    private $Service;
    public function __construct()
    {
        $this->Service = new IncomesService();
    }

    public function get()
    {
        return $this->Service->getList();
    }

    public function getIncomeById(Int $id)
    {
        return $this->Service->getIncomeById($id);
    }

    public function store(Request $request)
    {
        return $this->Service->createIncome(
            $request->get('name'),
            $request->get('value'),
            $request->get('entry_day'),
            $request->get('source_id'),
            $request->get('type_id'),
        );
    }

    public function edit(Incomes $incomes)
    {
        //
    }


    public function update(Request $request, Incomes $incomes)
    {
        //
    }

    public function disableIncome(Int $id)
    {
        return $this->Service->disableIncome($id);
    }

    public function enableIncome(Int $id)
    {
        return $this->Service->enableIncome($id);
    }
}