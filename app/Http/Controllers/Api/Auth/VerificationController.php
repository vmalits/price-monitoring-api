<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    private $authService;

    public function __construct()
    {
        $this->authService = app(AuthService::class);
    }

    public function verify(int $id, Request $request): JsonResponse
    {
        $response = $this->authService->verify($id, $request);
        return response()->json($response['message'], $response['status']);
    }

    public function resend(): JsonResponse
    {
        $response = $this->authService->resend();
        return response()->json($response['message'], $response['status']);
    }
}
