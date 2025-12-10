<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthenticationService;

class AuthenticationController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new AuthenticationService();
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $response = $this->service->login(
            $request->input('email'),
            $request->input('password')
        );

        if (isset($response['errors'])) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'errors' => $response['errors']
            ], $response['http']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => $response
        ], 200);
    }

    public function logout(Request $request)
    {
        $response = $this->service->logout($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ], 200);
    }
}
