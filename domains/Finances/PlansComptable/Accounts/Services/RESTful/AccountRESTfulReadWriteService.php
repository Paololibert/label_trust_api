<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\PlansComptable\Accounts\Services\RESTful\Contracts\AccountRESTfulReadWriteServiceContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * The ***`AccountRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Account" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Account" resource.
 * It implements the `AccountRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\Services\RESTful`***
 */
class AccountRESTfulReadWriteService extends RestJsonReadWriteService implements AccountRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the AccountRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

    /**
     * Add new sub-accounts to a plan comptable account.
     *
     * @param  string                                           $planComptableId    The unique identifier of the plan comptable to add sub-accounts to.
     * @param  string                                           $accountId          The unique identifier of the account to add sub-accounts to.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $subAccountsData    Data of the sub-accounts to be added.
     * @return \Illuminate\Http\JsonResponse                                        The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                              If there is an issue with adding the accounts.
     */
    public function addNewSubAccountsToAPlanAccount(string $planComptableId, string $accountId, \Core\Utils\DataTransfertObjects\DTOInterface $subAccountsData): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();
        
        try {

            // Logic to add accounts to the specified Plan Comptable
            $result = $this->readWriteService->getRepository()->attachSubAccounts(accountId: $accountId, subAccountDataArray: $subAccountsData->toArray()['sub_accounts'], filters: ["where" => [["plan_comptable_id", "=", $planComptableId]]]);

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
            // Begin the transaction
            DB::rollback();

            // Throw a ServiceException if there is an issue with adding the accounts
            throw new ServiceException(message: "Failed to add sub-accounts records to a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Updates existing sub-accounts of a plan comptable account.
     *
     * @param  string                                           $planComptableId            The unique identifier of the plan comptable to add sub-accounts to.
     * @param  string                                           $accountId                  The unique identifier of the account to add sub-accounts to.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $updatedSubAccountsData     Data of the sub-accounts to be added.
     * @return \Illuminate\Http\JsonResponse                                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                      If there is an issue with adding the accounts.
     */
    public function updateSubAccountsOfAPlanAccount(string $planComptableId, string $accountId, \Core\Utils\DataTransfertObjects\DTOInterface $updatedSubAccountsData): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            // Logic to add accounts to the specified Plan Comptable
            $result = $this->readWriteService->getRepository()->updateSubAccounts(accountId: $accountId, updatedSubAccountsData: $updatedSubAccountsData->toArray()['sub_accounts'], filters: ["where" => [["plan_comptable_id", "=", $planComptableId]]]);

            // If the result is false, throw a specific exception
            if (!$result) {
                throw new ServiceException("Failed to update sub-accounts records of a plan comptable. Update operation unsuccessful.");
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Sub Accounts updated successfully of a plan comptable account.',
                data: $result,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Begin the transaction
            DB::rollback();

            // Throw a ServiceException if there is an issue with updating the accounts
            throw new ServiceException(message: "Failed to update sub-accounts records of a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Deletes accounts from a Plan Comptable.
     *
     * @param  string                                           $planComptableId    The unique identifier of the Plan Comptable to delete accounts from.
     * @param  string                                           $accountId          The unique identifier of the account to delete sub-accounts from.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountIds         The IDs of the accounts to be deleted.
     * @return \Illuminate\Http\JsonResponse                                        The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                              If there is an issue with deleting the accounts.
     */
    public function deleteSubAccountsFromAPlanAccount(string $planComptableId, string $accountId, \Core\Utils\DataTransfertObjects\DTOInterface $accountIds): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            // Logic to delete accounts from the specified Plan Comptable
            $result = $this->readWriteService->getRepository()->deleteSubAccounts($accountId, $accountIds->toArray()['comptes'], ["where" => [["plan_comptable_id", "=", $planComptableId]]]);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to detach accounts from the Plan Comptable. The accounts were not detach.", 1);
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Sub Accounts deleted successfully from a plan comptable account.',
                data: $result,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {

            // Begin the transaction
            DB::rollback();

            // Throw a ServiceException if there is an issue with deleting the accounts
            throw new ServiceException(message: "Failed to delete sub-accounts records from a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

}