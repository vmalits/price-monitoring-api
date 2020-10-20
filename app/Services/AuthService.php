<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class AuthService
{
    public function register(RegisterRequest $request): void
    {
        $user = User::create($request->validated());
        $user->sendEmailVerificationNotification();
    }

    public function verify(int $id, Request $request): JsonResponse
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'message' => trans('auth.email_confirm_invalid_signature')
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = User::findOrFail($id);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return response()->json([
                'message' => trans('auth.email_confirmed')
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => trans('auth.email_already_confirmed')
        ], Response::HTTP_OK);
    }

    public function resend(): JsonResponse
    {
        $user = auth()->user();
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => trans('auth.email_confirmed')
            ], Response::HTTP_OK);
        }

        $user->sendEmailVerificationNotification();
        return response()->json([
            'message' => trans('auth.email_link_was_send')
        ], Response::HTTP_OK);
    }
}
