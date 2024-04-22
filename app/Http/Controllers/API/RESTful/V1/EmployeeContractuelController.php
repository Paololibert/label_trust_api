<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1;

use App\Http\Requests\EmployeeContractuels\v1\CreateEmployeeContractuelRequest;
use App\Http\Requests\EmployeeContractuels\v1\UpdateEmployeeContractuelRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts\EmployeeContractuelRESTfulQueryServiceContract;
use Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts\EmployeeContractuelRESTfulReadWriteServiceContract;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ResourceRequest;
use Domains\Employees\EmployeeContractuels\DataTransfertObjects\CreateEmployeeContractuelAssignmentDTO;
use Domains\Employees\EmployeeContractuels\PaySlips\DataTransfertObjects\CreatePaySlipDTO;
use Domains\Employees\EmployeeContractuels\PaySlips\DataTransfertObjects\UpdatePaySlipDTO;

/**
 * **`EmployeeContractuelController`**
 *
 * Controller for managing EmployeeContractuel resources. This controller extends the RESTfulController
 * and provides CRUD operations for EmployeeContractuel resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class EmployeeContractuelController extends RESTfulResourceController
{
    /**
     * Create a new EmployeeContractuelController instance.
     *
     * @param \Domains\EmployeeContractuels\Services\RESTful\Contracts\EmployeeContractuelRESTfulQueryServiceContract $EmployeeContractuelRESTfulQueryService
     *        The EmployeeContractuel RESTful Query Service instance.
     */
    public function __construct(EmployeeContractuelRESTfulReadWriteServiceContract $EmployeeContractuelRESTfulReadWriteService, EmployeeContractuelRESTfulQueryServiceContract $EmployeeContractuelRESTfulQueryService)
    {
        parent::__construct($EmployeeContractuelRESTfulReadWriteService, $EmployeeContractuelRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateEmployeeContractuelRequest::class);
        $this->setRequestClass('update', UpdateEmployeeContractuelRequest::class);
    }

    
    /**
     * Assign User privileges to a user.
     *
     * @param  Request $request The request object containing the data for updating the resource.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the role privileges granted operation.
     */
    public function assignmentOfPost(Request $request): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ['dto' => new CreateEmployeeContractuelAssignmentDTO]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }
        
        return $this->restJsonReadWriteService->assignmentOfPost($createRequest->getDto());
    }
    

    /**
     * Assign User privileges to a user.
     *
     * @param  Request $request The request object containing the data for updating the resource.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the role privileges granted operation.
     */
    public function terminateContract(Request $request, string $contractID, string $employeeContractuelID): JsonResponse
    {
        return $this->restJsonReadWriteService->terminateContract($contractID, $employeeContractuelID);
    }

    /**
     * Generate pay slip
     *
     * @param  string                           $employeeContractuelId      The unique identifier of the employee.
     * @param  Request                          $request                    The request object containing the data for updating the resource.
     * @return \Illuminate\Http\JsonResponse                                The JSON response indicating the status of the role privileges granted operation.
     */
    public function generatePaySlip(Request $request, string $employeeContractuelId): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ['dto' => new CreatePaySlipDTO(data: ["employee_contractuel_id" => $employeeContractuelId])]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }
        
        return $this->restJsonReadWriteService->generatePaySlip($employeeContractuelId, $createRequest->getDto());
    }

    /**
     * Update pay slip
     *
     * @param  string                           $employeeContractuelId     The unique identifier of the employee.
     * @param  Request                          $request        The request object containing the data for updating the resource.
     * @return \Illuminate\Http\JsonResponse                    The JSON response indicating the status of the role privileges granted operation.
     */
    public function updatePaySlip(Request $request, string $employeeContractuelId, string $paySlipId): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ['dto' => new UpdatePaySlipDTO(data: ["employee_non_contractuel_id" => $employeeContractuelId])]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }
        
        return $this->restJsonReadWriteService->updatePaySlip($employeeContractuelId, $paySlipId, $createRequest->getDto());
    }

    /**
     * Validate pay slip
     *
     * @param  string                           $employeeContractuelId     The unique identifier of the employee.
     * @param  Request                          $request        The request object containing the data for updating the resource.
     * @return \Illuminate\Http\JsonResponse                    The JSON response indicating the status of the role privileges granted operation.
     */
    public function validatePaySlip(Request $request, string $employeeContractuelId, string $paySlipId): JsonResponse
    {        
        return $this->restJsonReadWriteService->validatePaySlip($employeeContractuelId, $paySlipId);
    }

    /**
     * PaySlips
     *
     * @param  string                           $employeeContractuelId     The unique identifier of the employee.
     * @param  Request                          $request        The request object containing the data for updating the resource.
     * @return \Illuminate\Http\JsonResponse                    The JSON response indicating the status of the role privileges granted operation.
     */
    public function paySlips(Request $request, string $employeeContractuelId): JsonResponse
    {        
        return $this->restJsonQueryService->pay_slips($employeeContractuelId);
    }
    
}
