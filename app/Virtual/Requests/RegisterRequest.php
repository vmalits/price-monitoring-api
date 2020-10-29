<?php
declare(strict_types=1);

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Register request",
 *      description="request body data",
 *      type="object",
 * )
 */
class RegisterRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      example="John White"
     * )
     *
     * @var string
     */
    public $name;

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

    /**
     * @OA\Property(
     *      title="password_confirmation",
     *      example="password"
     * )
     *
     * @var string
     */
    public $password_confirmation;
}
