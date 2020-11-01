<?php
declare(strict_types=1);

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="CompanyResource",
 *     description="Company resource",
 *     @OA\Xml(
 *         name="CompanyResource"
 *     )
 * )
 */
class CompanyResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Company[]
     */
    private $data;
}
