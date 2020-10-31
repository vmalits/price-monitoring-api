<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *      path="/auth/login",
 *      operationId="Login",
 *      tags={"Auth"},
 *      summary="Login",
 *      description="Login",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *       ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad Request"
 *       ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 *     @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 * Class LoginController
 * @package App\Http\Controllers\Api\Auth
 */
class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $authService = app(AuthService::class);
        $token = $authService->login($request);

        return response()
            ->json(
                [
                    'token' => $token
                ],
                Response::HTTP_OK
            );
    }
}
