<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class AuthService
{
    public function register(RegisterRequest $request): void
    {
        $user = User::create($request->validated());
        $user->sendEmailVerificationNotification();
    }

    public function verify(int $id, Request $request): array
    {
        if (!$request->hasValidSignature()) {
            return [
                'message' => trans('auth.email_confirm_invalid_signature'),
                'status' => Response::HTTP_UNAUTHORIZED
            ];
        }
        $user = User::findOrFail($id);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return [
                'message' => trans('auth.email_confirmed'),
                'status' => Response::HTTP_OK
            ];
        }

        return [
            'message' => trans('auth.email_already_confirmed'),
            'status' => Response::HTTP_OK
        ];
    }

    public function resend(): array
    {
        $user = auth()->user();
        if ($user->hasVerifiedEmail()) {
            return [
                'message' => trans('auth.email_confirmed'),
                'status' => Response::HTTP_OK
            ];
        }

        $user->sendEmailVerificationNotification();
        return [
            'message' => trans('auth.email_link_was_send'),
            'status' => Response::HTTP_OK
        ];
    }
}
