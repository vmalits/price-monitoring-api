<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DontVerifiedEmailException extends Exception
{
    public function render(): JsonResponse
    {
        return response()
            ->json(
                [
                    'message' => $this->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
    }
}
