<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Price monitoring Documentation",
 *      description="Price Monitoring Swagger OpenApi",
 *      @OA\Contact(
 *          email="vladimir.malits@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *      @OA\Server(
 *          url=L5_SWAGGER_CONST_HOST,
 *          description="Demo API Server"
 *      )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected const STATUS_SUCCESS = 'success';
    protected const STATUS_WARNING = 'warning';

    public function responseOk(string $message): JsonResponse
    {
        return response()
            ->json(
                [
                    'message' => $message,
                    'type' => self::STATUS_SUCCESS
                ],
                Response::HTTP_OK
            );
    }

    public function responseCreated(string $message): JsonResponse
    {
        return response()
            ->json(
                [
                    'message' => $message,
                    'type' => self::STATUS_SUCCESS
                ],
                Response::HTTP_CREATED
            );
    }

    public function responseUnauthorized(string $message): JsonResponse
    {
        return response()
            ->json(
                [
                    'message' => $message,
                    'type' => self::STATUS_WARNING
                ],
                Response::HTTP_UNAUTHORIZED
            );
    }
}
