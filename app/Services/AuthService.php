<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class AuthService
{
    public function register(RegisterRequest $request): void
    {
        $user = User::create($request->validated());
        $user->sendEmailVerificationNotification();
    }

    /**
     * @param int $id
     * @param Request $request
     * @return string|null
     * @throws ValidationException
     */
    public function verify(int $id, Request $request): ?string
    {
        if (!$request->hasValidSignature()) {
            throw ValidationException::withMessages([
                'signature' => [trans('auth.email_confirm_invalid_signature')]
            ]);
        }

        $user = User::findOrFail($id);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return trans('auth.email_confirmed');
        }

        return trans('auth.email_already_confirmed');
    }

    public function resend(): string
    {
        $user = auth()->user();
        if ($user->hasVerifiedEmail()) {
            return trans('auth.email_confirmed');
        }

        $user->sendEmailVerificationNotification();
        return trans('auth.email_link_was_send');
    }
}
