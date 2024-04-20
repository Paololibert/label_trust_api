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
use Domains\Employees\EmployeeNonContractuels\DataTransfertObjects\InvoiceDTO;
use Domains\Employees\EmployeeNonContractuels\DataTransfertObjects\InvoiceEditionDTO;

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

    /**
     * Generate invoice
     *
     * @param  string                           $employeeId     The unique identifier of the employee.
     * @param  Request                          $request        The request object containing the data for updating the resource.
     * @return \Illuminate\Http\JsonResponse                    The JSON response indicating the status of the role privileges granted operation.
     */
    public function generateInvoice(Request $request, string $employeeId): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ['dto' => new InvoiceDTO(data: ["employee_non_contractuel_id" => $employeeId])]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }
        
        return $this->restJsonReadWriteService->generateInvoice($employeeId, $createRequest->getDto());
    }

    /**
     * Update invoice
     *
     * @param  string                           $employeeId     The unique identifier of the employee.
     * @param  Request                          $request        The request object containing the data for updating the resource.
     * @return \Illuminate\Http\JsonResponse                    The JSON response indicating the status of the role privileges granted operation.
     */
    public function updateInvoice(Request $request, string $employeeId, string $invoiceId): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ['dto' => new InvoiceEditionDTO(data: ["employee_non_contractuel_id" => $employeeId])]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }
        
        return $this->restJsonReadWriteService->updateInvoice($employeeId, $invoiceId, $createRequest->getDto());
    }

    /**
     * Validate invoice
     *
     * @param  string                           $employeeId     The unique identifier of the employee.
     * @param  Request                          $request        The request object containing the data for updating the resource.
     * @return \Illuminate\Http\JsonResponse                    The JSON response indicating the status of the role privileges granted operation.
     */
    public function validateInvoice(Request $request, string $employeeId, string $invoiceId): JsonResponse
    {        
        return $this->restJsonReadWriteService->validateInvoice($employeeId, $invoiceId);
    }

    /**
     * Invoices
     *
     * @param  string                           $employeeId     The unique identifier of the employee.
     * @param  Request                          $request        The request object containing the data for updating the resource.
     * @return \Illuminate\Http\JsonResponse                    The JSON response indicating the status of the role privileges granted operation.
     */
    public function invoices(Request $request, string $employeeId): JsonResponse
    {        
        return $this->restJsonQueryService->invoices($employeeId);
    }

}
