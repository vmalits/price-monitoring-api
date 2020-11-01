<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * @OA\Get(
     *      path="/companies",
     *      operationId="getComapaniesList",
     *      tags={"Companies"},
     *      summary="Get list of companies",
     *      description="Returns list of companies",
     *      security={
     *          {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *      @OA\Schema(
     *          type="integer"
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CompanyResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = $request->get('perPage', 5);
        return CompanyResource::collection(Company::paginate($perPage));
    }

    /**
     * @OA\Post(
     *      path="/companies",
     *      operationId="storeCompany",
     *      tags={"Companies"},
     *      summary="Store new company",
     *      description="Returns company data",
     *      security={
     *          {"bearer": {}}
     *      },
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CompanyRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Company")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @param CompanyRequest $request
     * @return JsonResponse|object
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        $company = Company::firstOrCreate($request->validated());
        return (new CompanyResource($company))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/companies/{id}",
     *      operationId="getCompanyById",
     *      tags={"Companies"},
     *      summary="Get company information",
     *      description="Returns company data",
     *      security={
     *          {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Company id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Company")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @param Company $company
     * @return CompanyResource
     */

    public function show(Company $company): CompanyResource
    {
        return new CompanyResource($company);
    }

    /**
     * @OA\Put(
     *      path="/companies/{id}",
     *      operationId="updateCompany",
     *      tags={"Companies"},
     *      summary="Update existing company",
     *      description="Returns updated company data",
     *      security={
     *          {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Company id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CompanyRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Company")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     * @param CompanyRequest $request
     * @param Company $company
     * @return JsonResponse
     */
    public function update(CompanyRequest $request, Company $company): JsonResponse
    {
        $company->update($request->validated());
        return (new CompanyResource($company))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *      path="/companies/{id}",
     *      operationId="deleteCompany",
     *      tags={"Companies"},
     *      summary="Delete existing company",
     *      description="Deletes a record and returns no content",
     *      security={
     *          {"bearer": {}}
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Company id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     * @param Company $company
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Company $company): JsonResponse
    {
        $company->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
