<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeTypes;
use App\Http\Controllers\Controller;
use App\Services\IncomeTypesService;

class IncomeTypesController extends Controller
{
    private $Service;
    public function __construct()
    {
        $this->Service = new IncomeTypesService();
    }

    public function get()
    {
        return $this->Service->getList();
    }

    public function store(Request $request)
    {
        //
    }

    public function show(IncomeTypes $incomeTypes)
    {
        //
    }

    public function edit(IncomeTypes $incomeTypes)
    {
        //
    }

    public function update(Request $request, IncomeTypes $incomeTypes)
    {
        //
    }

    public function destroy(IncomeTypes $incomeTypes)
    {
        //
    }
}
