<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class DontVerifiedEmailException extends Exception
{
    public function render()
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
