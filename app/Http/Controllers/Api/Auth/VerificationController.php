<?php
declare(strict_types=1);

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
        $message = $this->authService->verify($id, $request);
        return $this->responseOk($message);
    }

    public function resend(): JsonResponse
    {
        $message = $this->authService->resend();
        return $this->responseOk($message);
    }
}
