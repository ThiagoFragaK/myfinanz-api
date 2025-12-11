<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsersService;

class UsersController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new UsersService();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $response = $this->service->updatePassword(
            $request->user()->id,
            $request->input('current_password'),
            $request->input('new_password')
        );

        if (isset($response['errors'])) {
            return response()->json([
                'success' => false,
                'message' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => $response['message']
        ], 200);
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'language' => 'required|string|in:en,deu,es,pt',
            'currency' => 'required|string|in:BRL,EUR,USD,ARS',
        ]);

        $response = $this->service->updateSettings(
            $request->user()->id,
            $request->input('language'),
            $request->input('currency')
        );

        if (isset($response['errors'])) {
            return response()->json([
                'success' => false,
                'message' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully',
            'user' => $response['user']
        ], 200);
    }
}
