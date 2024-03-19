<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1;

use App\Http\Requests\EmployeeNonContractuels\v1\CreateEmployeeNonContractuelRequest;
use App\Http\Requests\EmployeeNonContractuels\v1\UpdateEmployeeNonContractuelRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts\EmployeeNonContractuelRESTfulQueryServiceContract;
use Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts\EmployeeNonContractuelRESTfulReadWriteServiceContract;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\ResourceRequest;
use Domains\Employees\EmployeeNonContractuels\DataTransfertObjects\CreateEmployeeNonContractuelDTO;

/**
 * **`EmployeeNonContractuelController`**
 *
 * Controller for managing EmployeeNonContractuel resources. This controller extends the RESTfulController
 * and provides CRUD operations for EmployeeNonContractuel resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class EmployeeNonContractuelController extends RESTfulResourceController
{
    /**
     * Create a new EmployeeNonContractuelController instance.
     *
     * @param \Domains\EmployeeNonContractuels\Services\RESTful\Contracts\EmployeeNonContractuelRESTfulQueryServiceContract $EmployeeNonContractuelRESTfulQueryService
     *        The EmployeeNonContractuel RESTful Query Service instance.
     */
    public function __construct(EmployeeNonContractuelRESTfulReadWriteServiceContract $EmployeeNonContractuelRESTfulReadWriteService, EmployeeNonContractuelRESTfulQueryServiceContract $EmployeeNonContractuelRESTfulQueryService)
    {
        parent::__construct($EmployeeNonContractuelRESTfulReadWriteService, $EmployeeNonContractuelRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateEmployeeNonContractuelRequest::class);
        $this->setRequestClass('update', UpdateEmployeeNonContractuelRequest::class);
    }

    
    /**
     * Assign User privileges to a user.
     *
     * @param   string            $employeeId           The unique identifier of the employee.
     * @param   string            $newCategoryId        The unique identifier of the contract.
     * @param  Request            $request The request object containing the data for updating the resource.
     * @return \Illuminate\Http\JsonResponse            The JSON response indicating the status of the role privileges granted operation.
     */
    public function changeCategoryOfNonContractualEmployee(Request $request, string $employeeId, string $newCategoryId): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ['dto' => new CreateEmployeeNonContractuelDTO]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }
        
        return $this->restJsonReadWriteService->changeCategoryOfNonContractualEmployee($employeeId,$newCategoryId, $createRequest->getDto());
    }

}
