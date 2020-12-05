<?php
declare(strict_types=1);

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Role request",
 *      description="request body data",
 *      type="object",
 * )
 */
class RoleRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      example="admin"
     * )
     *
     * @var string
     */
    public $name;
}
