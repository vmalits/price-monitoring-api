<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $authService = app(AuthService::class);
        $authService->register($request);
        return response()
            ->json(
                [
                    'message' => trans('auth.email_confirm')
                ],
                Response::HTTP_CREATED
            );
    }
}
