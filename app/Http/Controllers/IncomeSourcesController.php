<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeSources;
use App\Http\Controllers\Controller;
use App\Services\IncomeSourcesService;
class IncomeSourcesController extends Controller
{
    private $Service;
    public function __construct()
    {
        $this->Service = new IncomeSourcesService();
    }

    public function get()
    {
        return $this->Service->getList();
    }
    
    public function store(Request $request)
    {
        return $this->Service->createIncomeSource([
            "name" => $request->get("name"),
        ]);
    }

    public function show(IncomeSources $incomeSources)
    {
        //
    }

    public function edit(IncomeSources $incomeSources)
    {
        //
    }

    public function update(Request $request, IncomeSources $incomeSources)
    {
        //
    }

    public function destroy(IncomeSources $incomeSources)
    {
        //
    }
}
