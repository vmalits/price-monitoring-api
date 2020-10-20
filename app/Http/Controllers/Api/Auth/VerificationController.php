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
        return $this->authService->verify($id, $request);
    }

    public function resend(): JsonResponse
    {
        return $this->authService->resend();
    }
}
