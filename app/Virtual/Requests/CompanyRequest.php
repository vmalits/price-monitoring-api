<?php
declare(strict_types=1);

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Company request",
 *      description="request body data",
 *      type="object",
 * )
 */
class CompanyRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      example="orange.md"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="email",
     *      example="orange@md"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="phone_number",
     *      example="089424913"
     * )
     *
     * @var string
     */
    public $phone_number;
}
