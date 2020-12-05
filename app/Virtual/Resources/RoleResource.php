<?php
declare(strict_types=1);

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="RoleResource",
 *     description="Role resource",
 *     @OA\Xml(
 *         name="RoleResource"
 *     )
 * )
 */
class RoleResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Role[]
     */
    private $data;
}
