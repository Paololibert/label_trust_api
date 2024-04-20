<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;
use Core\Utils\DataTransfertObjects\DTOInterface;

/**
 * Interface ***`EmployeeNonContractuelRESTfulReadWriteServiceContract`***
 *
 * The `EmployeeNonContractuelRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the EmployeeNonContractuel module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on EmployeeNonContractuel resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts`***
 */
interface EmployeeNonContractuelRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{

    /**
     * Terminate a contract.
     *
     * @param   string            $employeeId        The unique identifier of the employee.
     * @param   string            $newCategoryId     The unique identifier of the category.
     * @param   \Core\Utils\DataTransfertObjects\ DTOInterface $data              The rest of the data.
     *
     * @return  \Illuminate\Http\JsonResponse        Whether the contract is terminate successfully.
     */
    public function changeCategoryOfNonContractualEmployee(string $employeeId, string $newCategoryId, DTOInterface $data): \Illuminate\Http\JsonResponse;

    /**
     * Generate invoice
     *
     * @param  string                                           $planComptableId            The unique identifier of the employee.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $data                       Invoice items data.
     * @return \Illuminate\Http\JsonResponse                                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                      If there is an issue.
     */
    public function generateInvoice(string $employeeId, DTOInterface $data): \Illuminate\Http\JsonResponse;
    
    /**
     * Update invoice
     *
     * @param  string                                           $employeeId The unique identifier of the employee.
     * @param  string                                           $invoiceId The unique identifier of the invoice.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $data       Invoice items data.
     * @return \Illuminate\Http\JsonResponse                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                      If there is an issue.
     */
    public function updateInvoice(string $employeeId, string $invoiceId, DTOInterface $data): \Illuminate\Http\JsonResponse;

    /**
     * Validate invoice
     *
     * @param  string                                           $employeeId The unique identifier of the employee.
     * @param  string                                           $invoiceId  The unique identifier of the invoice.
     * @return \Illuminate\Http\JsonResponse                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                      If there is an issue.
     */
    public function validateInvoice(string $employeeId, string $invoiceId): \Illuminate\Http\JsonResponse;
}