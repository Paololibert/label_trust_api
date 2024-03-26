<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`AccountRESTfulReadWriteServiceContract`***
 *
 * The `AccountRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the Accounts module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on Account resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\Services\RESTful\Contracts`***
 */
interface AccountRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
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
    public function addNewSubAccountsToAPlanAccount(string $planComptableId, string $accountId, \Core\Utils\DataTransfertObjects\DTOInterface $subAccountsData): \Illuminate\Http\JsonResponse;

    /**
     * Delete sub-accounts from a plan comptable account.
     *
     * @param  string                                           $planComptableId    The unique identifier of the Plan Comptable to delete accounts from.
     * @param  string                                           $accountId          The unique identifier of the account to delete sub-accounts from.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountIds         The IDs of the accounts to be deleted.
     * @return \Illuminate\Http\JsonResponse                                        The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                              If there is an issue with deleting the accounts.
     */
    public function deleteSubAccountsFromAPlanAccount(string $planComptableId, string $accountId, \Core\Utils\DataTransfertObjects\DTOInterface $accountIds): \Illuminate\Http\JsonResponse;
    
}