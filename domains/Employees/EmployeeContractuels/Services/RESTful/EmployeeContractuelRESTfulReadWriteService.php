<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeContractuels\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts\EmployeeContractuelRESTfulReadWriteServiceContract as ContractsEmployeeContractuelRESTfulReadWriteServiceContract;

use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Employees\EmployeeContractuels\PaySlips\Repositories\PaySlipReadWriteRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * The ***`EmployeeContractuelRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "EmployeeContractuel" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "EmployeeContractuel" resource.
 * It implements the `EmployeeContractuelRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Employees\EmployeeContractuels\Services\RESTful`***
 */
class EmployeeContractuelRESTfulReadWriteService extends RestJsonReadWriteService implements ContractsEmployeeContractuelRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the EmployeeContractuelRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
        
    }
    
    /**
     * Assign a poste to an employeecontractuel and create a new contract and optionally a new salaire.
     *
     * @param \Core\Utils\DataTransfertObjects\ DTOInterface $data
     * @return  \Illuminate\Http\JsonResponse    
     */
    public function assignmentOfPost(DTOInterface $data): \Illuminate\Http\JsonResponse{
        $result = $this->queryService->getRepository()->assignmentOfPost($data->toArray()); 

        return JsonResponseTrait::success(
            message: 'New Post is assign successfully',
            data: $result,
            status_code: Response::HTTP_CREATED
        );
    }

    /**
     * Terminate a contract.
     *
     *
     * @param   string            $contractId        The unique identifier of the contract.
     * @param   string            $employeeId        The unique identifier of the employee.
     *
     * @return  \Illuminate\Http\JsonResponse        Whether the contract is terminate successfully.
     */
    public function terminateContract(string $contractId, string $employeeId): \Illuminate\Http\JsonResponse
    {
        $result = $this->readWriteService->getRepository()->terminateContract($contractId,$employeeId); 

        return JsonResponseTrait::success(
            message: 'Contract terminate successfully',
            data: $result,
            status_code: Response::HTTP_OK
        );
    }

    /**
     * Generate pay slip
     *
     * @param  string                                           $employeeId The unique identifier of the employee contractuel.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $data       Pay slip items data.
     * @return \Illuminate\Http\JsonResponse                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                      If there is an issue.
     */
    public function generatePaySlip(string $employeeContractuelId, DTOInterface $data): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            $result = app(PaySlipReadWriteRepository::class)->create(array_merge($data->toArray(), ['employee_contractuel_id' => $employeeContractuelId]));

            // If the result is false, throw a specific exception
            if (!$result) {
                throw new ServiceException("Failed to generate pay slip.");
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Pay slip generated successfully',
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
     * Update pay slip
     *
     * @param  string                                           $employeeContractuelId The unique identifier of the employee contractuel.
     * @param  string                                           $paySlipId The unique identifier of the pay slip.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $data       Pay slip items data.
     * @return \Illuminate\Http\JsonResponse                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                      If there is an issue.
     */
    public function updatePaySlip(string $employeeContractuelId, string $paySlipId, DTOInterface $data): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            $result = app(PaySlipReadWriteRepository::class)->update($paySlipId, array_merge($data->toArray(), ['employee_contractuel_id' => $employeeContractuelId]));

            // If the result is false, throw a specific exception
            if (!$result) {
                throw new ServiceException("Failed to update pay slip.");
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Pay slip editd successfully',
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
     * Validate pay slip
     *
     * @param  string                                           $employeeContractuelId The unique identifier of the employee contractuel.
     * @param  string                                           $paySlipId The unique identifier of the pay slip.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $data       Pay slip items data.
     * @return \Illuminate\Http\JsonResponse                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                      If there is an issue.
     */
    public function validatePaySlip(string $employeeContractuelId, string $paySlipId): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            $result = app(PaySlipReadWriteRepository::class)->validatePaySlip($employeeContractuelId, $paySlipId);

            // If the result is false, throw a specific exception
            if (!$result) {
                throw new ServiceException("Failed to validate pay slip.");
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Pay slip validated successfully',
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