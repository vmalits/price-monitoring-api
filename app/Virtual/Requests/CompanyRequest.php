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
}
