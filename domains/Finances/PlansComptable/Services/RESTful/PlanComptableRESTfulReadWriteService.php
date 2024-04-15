<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\PlansComptable\Services\RESTful\Contracts\PlanComptableRESTfulReadWriteServiceContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * The ***`PlanComptableRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "PlanComptable" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "PlanComptable" resource.
 * It implements the `PlanComptableRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\PlansComptable\Services\RESTful`***
 */
class PlanComptableRESTfulReadWriteService extends RestJsonReadWriteService implements PlanComptableRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the PlanComptableRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

    /**
     * Adds new accounts to a Plan Comptable.
     *
     * @param  string                                           $planComptableId    The unique identifier of the Plan Comptable to add accounts to.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountsData       Data of the accounts to be added.
     * @return \Illuminate\Http\JsonResponse                                        The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                              If there is an issue with adding the accounts.
     */
    public function addAccounts(string $planComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $accountsData): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();
        
        try {

            // Logic to add accounts to the specified Plan Comptable
            $result = $this->readWriteService->getRepository()->attachAccounts(planComptableId: $planComptableId, accountDataArray: $accountsData->toArray()['accounts']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to attach accounts to a Plan Comptable. The accounts were not detach.", 1);
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Accounts added successfully to the Plan Comptable.',
                data: $result,
                status_code: Response::HTTP_CREATED
            );
        } catch (CoreException $exception) {
            // Throw a ServiceException if there is an issue with adding the accounts
            throw new ServiceException(message: "Failed to add accounts records to a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Updates accounts in a Plan Comptable.
     *
     * @param  string                                           $planComptableId        The unique identifier of the Plan Comptable to update accounts in.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface                            $updatedAccountsData    Data of the accounts to be updated.
     * @return \Illuminate\Http\JsonResponse                                            The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                  If there is an issue with updating the accounts.
     */
    public function updateAccounts(string $planComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $updatedAccountsData): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Logic to update accounts in the specified Plan Comptable
            $result = $this->readWriteService->getRepository()->updateAccounts(planComptableId: $planComptableId, updatedAccountsData: $updatedAccountsData->toArray()['accounts']);

            // If the result is false, throw a specific exception
            if (!$result) {
                throw new ServiceException("Failed to update accounts in the Plan Comptable. Update operation unsuccessful.");
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Accounts updated successfully in the Plan Comptable.',
                data: $result,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Begin the transaction
            DB::rollback();

            // Throw a ServiceException if there is an issue with updating the accounts
            throw new ServiceException(message: "Failed to update accounts records of a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Deletes accounts from a Plan Comptable.
     *
     * @param  string                                           $planComptableId    The unique identifier of the Plan Comptable to delete accounts from.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountIds         The IDs of the accounts to be deleted.
     * @return \Illuminate\Http\JsonResponse                                        The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                              If there is an issue with deleting the accounts.
     */
    public function deleteAccounts(string $planComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $accountIds): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Logic to delete accounts from the specified Plan Comptable
            $result = $this->readWriteService->getRepository()->deleteAccounts(planComptableId: $planComptableId, deletedAccountIds: $accountIds->toArray()['comptes']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to detach accounts from the Plan Comptable. The accounts were not detach.", 1);
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Accounts deleted successfully from the Plan Comptable.',
                data: $result,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Begin the transaction
            DB::rollback();

            // Throw a ServiceException if there is an issue with deleting the accounts
            throw new ServiceException(message: "Failed to delete accounts records from a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Validate a Plan Comptable.
     *
     * @param  string                                   $planComptableId    The unique identifier of the Plan Comptable to validate.
     * @return \Illuminate\Http\JsonResponse                                The JSON response indicating the validation result.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                      If there is an issue with validating the Plan Comptable.
     */
    public function validatePlanComptable(string $planComptableId): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Logic to validate the specified Plan Comptable
            $result = $this->readWriteService->getRepository()->validatePlanComptable(planComptableId: $planComptableId);

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Plan Comptable validated successfully.',
                data: $result,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Begin the transaction
            DB::rollback();
    
            // Throw a ServiceException if there is an issue with validating a plan comptable
            throw new ServiceException(message: "Failed to validate a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }


    /**
     * Importer un plan comptable.
     *
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $data       The IDs of the accounts to be deleted.
     * @return \Illuminate\Http\JsonResponse                                The JSON response indicating the validation result.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                      If there is an issue with validating the Plan Comptable.
     */
    public function import(\Core\Utils\DataTransfertObjects\DTOInterface $data): \Illuminate\Http\JsonResponse{

        // Begin the transaction
        DB::beginTransaction();

        try {
            // Logic to validate the specified Plan Comptable
            $plan = $this->readWriteService->getRepository()->import(data: $data->toArray());

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Plan Comptable import successfully.',
                data: $plan,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Begin the transaction
            DB::rollback();
    
            // Throw a ServiceException if there is an issue with validating a plan comptable
            throw new ServiceException(message: "Failed to import: " . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}