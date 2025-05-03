<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeTypes;
use App\Http\Controllers\Controller;
use App\Services\IncomeTypesService;
use Ramsey\Uuid\Type\Integer;

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
        $status = $this->Service->createIncomeType([
            "name" => $request->get("name"),
            "created_at" => now(),
        ]);

        if($status)
        {
            return response()->json((object) [
                "message" => "Income type created successfully",
                "status_http" => 201
            ]);
        }

        return response()->json((object) [
            "message" => "Income type failed to be created.",
            "status_http" => 500
        ]);
    }

    public function show(Int $id)
    {
        return response()->json((object) [
            "message" => "Income type has been returned successfully",
            "data" => $this->Service->getIncomeTypeById($id),
            "status_http" => 200
        ]);
    }

    public function edit(Int $id, Request $request)
    {
        return $this->Service->editIncomeType(
            $id,
            $request->get("name"),
        );
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
