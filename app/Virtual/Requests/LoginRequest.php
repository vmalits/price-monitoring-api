<?php
declare(strict_types=1);

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Login request",
 *      description="request body data",
 *      type="object",
 * )
 */
class LoginRequest
{
    /**
     * @OA\Property(
     *      title="email",
     *      example="john_white@gmail.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="password",
     *      example="password"
     * )
     *
     * @var string
     */
    public $password;
}
