<?php
declare(strict_types=1);

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Role",
 *     description="Role model",
 * )
 */
class Role
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *     title="name",
     *     description="name",
     * )
     *
     * @var string
     */
    private $name;
}
