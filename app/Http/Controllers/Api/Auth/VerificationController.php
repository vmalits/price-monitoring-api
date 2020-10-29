<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VerificationController extends Controller
{
    private $authService;

    public function __construct()
    {
        $this->authService = app(AuthService::class);
    }

    /**
     * @OA\Get(
     *      path="/auth/email/verify",
     *      operationId="Verify email",
     *      tags={"Auth"},
     *      summary="Verify email",
     *      description="Verify email",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="expires",
     *          description="expires",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="hash",
     *          description="hash",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="signature",
     *          description="signature",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function verify(int $id, Request $request): JsonResponse
    {
        $message = $this->authService->verify($id, $request);
        return $this->responseOk($message);
    }

    /**
     * @OA\Get(
     *      path="/auth/email/resend",
     *      operationId="Resend",
     *      tags={"Auth"},
     *      summary="Resend email",
     *      description="Resend email",
     *      security={
     *          {"bearer": {}}
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function resend(): JsonResponse
    {
        $message = $this->authService->resend();
        return $this->responseOk($message);
    }
}
