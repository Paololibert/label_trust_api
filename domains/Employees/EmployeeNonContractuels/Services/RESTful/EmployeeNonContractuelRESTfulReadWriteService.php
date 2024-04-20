<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts\EmployeeNonContractuelRESTfulReadWriteServiceContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * The ***`EmployeeNonContractuelRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "EmployeeNonContractuel" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "EmployeeNonContractuel" resource.
 * It implements the `EmployeeNonContractuelRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Employees\EmployeeNonContractuels\Services\RESTful`***
 */
class EmployeeNonContractuelRESTfulReadWriteService extends RestJsonReadWriteService implements EmployeeNonContractuelRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the EmployeeNonContractuelRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }


    /**
     * Changing Category.
     *
     * @param   string            $employeeId           The unique identifier of the employee.
     * @param   string            $newCategoryId        The unique identifier of the contract. 
     * 
     * @param   \Core\Utils\DataTransfertObjects\ DTOInterface $data               The order data
     * 
     * @return  \Illuminate\Http\JsonResponse           Whether the category is changed successfully.
     */
    public function changeCategoryOfNonContractualEmployee(string $employeeId, string $newCategoryId, DTOInterface $data): \Illuminate\Http\JsonResponse
    {
        $result = $this->readWriteService->getRepository()->changeCategoryOfNonContractualEmployee($employeeId,  $newCategoryId, $data->toArray());

        return JsonResponseTrait::success(
            message: 'Category changed successfully',
            data: $result,
            status_code: Response::HTTP_OK
        );
    }

    /**
     * Generate invoice
     *
     * @param  string                                           $employeeId The unique identifier of the employee.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $data       Invoice items data.
     * @return \Illuminate\Http\JsonResponse                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                      If there is an issue.
     */
    public function generateInvoice(string $employeeId, DTOInterface $data): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            $result = $this->readWriteService->getRepository()->generateInvoice($employeeId, $data->toArray());

            // If the result is false, throw a specific exception
            if (!$result) {
                throw new ServiceException("Failed to generate invoice.");
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Invoice generated successfully',
                data: $result,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Begin the transaction
            DB::rollback();

            // Throw a ServiceException if there is an issue with updating the accounts
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

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
    public function updateInvoice(string $employeeId, string $invoiceId, DTOInterface $data): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {


            $result = $this->readWriteService->getRepository()->updateInvoice($employeeId, $invoiceId, $data->toArray());

            // If the result is false, throw a specific exception
            if (!$result) {
                throw new ServiceException("Failed to update invoice.");
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Invoice editd successfully',
                data: $result,
                status_code: Response::HTTP_OK
            );
            
        } catch (CoreException $exception) {
            // Begin the transaction
            DB::rollback();

            // Throw a ServiceException if there is an issue with updating the accounts
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Validate invoice
     *
     * @param  string                                           $employeeId The unique identifier of the employee.
     * @param  string                                           $invoiceId The unique identifier of the invoice.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $data       Invoice items data.
     * @return \Illuminate\Http\JsonResponse                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                      If there is an issue.
     */
    public function validateInvoice(string $employeeId, string $invoiceId): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            $result = $this->readWriteService->getRepository()->validateInvoice($employeeId, $invoiceId);

            // If the result is false, throw a specific exception
            if (!$result) {
                throw new ServiceException("Failed to validate invoice.");
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Invoice validated successfully',
                data: $result,
                status_code: Response::HTTP_OK
            );
            
        } catch (CoreException $exception) {
            // Begin the transaction
            DB::rollback();

            // Throw a ServiceException if there is an issue with updating the accounts
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
