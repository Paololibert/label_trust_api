<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1;

use App\Http\Requests\CategoriesOfEmployees\v1\CreateCategoryOfEmployeeRequest;
use App\Http\Requests\CategoriesOfEmployees\v1\UpdateCategoryOfEmployeeRequest;
use App\Http\Requests\ResourceRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\DataTransfertObjects\CategoryOfEmployeeTauxDTO;
use Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\DataTransfertObjects\CreateCategoryOfEmployeeTauxDTO;
use Domains\CategoriesOfEmployees\Services\RESTful\Contracts\CategoryOfEmployeeRESTfulQueryServiceContract;
use Domains\CategoriesOfEmployees\Services\RESTful\Contracts\CategoryOfEmployeeRESTfulReadWriteServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * **`CategoryOfEmployeeController`**
 *
 * Controller for managing poste resources. This controller extends the RESTfulController
 * and provides CRUD operations for poste resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class CategoryOfEmployeeController extends RESTfulResourceController
{
    /**
     * Create a new CategoryOfEmployeeController instance.
     *
     * @param \Domains\CategoriesOfEmployees\Services\RESTful\Contracts\CategoryOfEmployeeRESTfulQueryServiceContract $categoryOfEmployeeRESTfulQueryService
     *        The CategoryOfEmployee RESTful Query Service instance.
     */
    public function __construct(CategoryOfEmployeeRESTfulReadWriteServiceContract $categoryOfEmployeeRESTfulReadWriteService, CategoryOfEmployeeRESTfulQueryServiceContract $categoryOfEmployeeRESTfulQueryService)
    {
        parent::__construct($categoryOfEmployeeRESTfulReadWriteService, $categoryOfEmployeeRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateCategoryOfEmployeeRequest::class);
        $this->setRequestClass('update', UpdateCategoryOfEmployeeRequest::class);
    }

    /**
     * Assign User privileges to a user.
     *
     * @param  Request $request The request object containing the data for updating the resource.
     * @param  string                                     $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the role privileges granted operation.
     */
    public function attachTauxToACategoryOfEmployee(Request $request, string $id): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ["dto" => new CreateCategoryOfEmployeeTauxDTO]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }
        
        return $this->restJsonReadWriteService->attachTauxToACategoryOfEmployee($id, $createRequest->getDto());
    }

    /**
     * Revoke role privileges from a user.
     *
     * @param  Request $request The request object containing the data for updating the resource.
     * @param  string                                     $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the role privileges revoked operation.
     */
    public function detachTauxFromACategoryOfEmployee(Request $request, string $id): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ["dto" => new CategoryOfEmployeeTauxDTO]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        return $this->restJsonReadWriteService->detachTauxFromACategoryOfEmployee($id, $createRequest->getDto());
    }

    /**
     * Fetch user granted role privileges.
     *
     * @param  string                                     $id      The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the role privileges fetched operation.
     */
    public function fetchCategoryOfEmployeeTaux(string $id): JsonResponse
    {
        return $this->restJsonQueryService->fetchCategoryOfEmployeeTaux($id);
    }
}
