<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cards;
use App\Http\Controllers\Controller;
use App\Services\CardsService;

class CardsController extends Controller
{
    private $Service;
    public function __construct()
    {
        $this->Service = new CardsService();
    }

    public function get()
    {
        return response()->json([
            'success' => true,
            'message' => 'List retrieved successfully',
            'data' => $this->Service->getList()
        ], 200);
    }

    public function getCardById(Int $id)
    {
        return response()->json([
            'success' => true,
            'message' => "Card retrieved successfully",
            'data' => $this->Service->getCardById($id)
        ], 200);
    }

    public function store(Request $request)
    {
        $response = $this->Service->createCard(
            $request->get("name"),
            $request->get("turn_day"),
            $request->get("limit"),
        );
        
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to create Card",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Card created successfully",
            'data' => $response
        ], 201);
    }

    public function edit(Int $id, Request $request)
    {
        $payment = $this->Service->editCard(
            $id,
            $request->get("name"),
            $request->get("turn_day"),
            $request->get("limit"),
        );
        
        if(isset($income['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to edit the Card",
                'errors' => $income['errors']
            ], $income['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Card retrieved successfully",
            'data' => $payment
        ], 200);
    }

    public function disableCard(Int $id)
    {
        $response =  $this->Service->disableCard($id);
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to disable Card",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Card disabled successfully",
            'data' => $response
        ], 201);
    }

    public function enableCard(Int $id)
    {
        $response = $this->Service->enableCard($id);
        if(isset($response['errors']))
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to enable Card",
                'error' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => "Card enable successfully",
            'data' => $response
        ], 201);
    }
}