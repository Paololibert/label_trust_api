<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`PlanComptableRESTfulReadWriteServiceContract`***
 *
 * The `PlanComptableRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the PlansComptable module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on PlanComptable resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Finances\PlansComptable\Services\RESTful\Contracts`***
 */
interface PlanComptableRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
    
    /**
     * Adds new accounts to a Plan Comptable.
     *
     * @param  string                                           $planComptableId    The unique identifier of the Plan Comptable to add accounts to.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountsData       Data of the accounts to be added.
     * @return \Illuminate\Http\JsonResponse                                        The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                              If there is an issue with adding the accounts.
     */
    public function addAccounts(string $planComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $accountsData): \Illuminate\Http\JsonResponse;
    
    /**
     * Updates accounts in a Plan Comptable.
     *
     * @param  string                                           $planComptableId        The unique identifier of the Plan Comptable to update accounts in.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $updatedAccountsData    Data of the accounts to be updated.
     * @return \Illuminate\Http\JsonResponse                                            The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                  If there is an issue with updating the accounts.
     */
    public function updateAccounts(string $planComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $updatedAccountsData): \Illuminate\Http\JsonResponse;

    /**
     * Deletes accounts from a Plan Comptable.
     *
     * @param  string                                           $planComptableId    The unique identifier of the Plan Comptable to delete accounts from.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountIds         The IDs of the accounts to be deleted.
     * @return \Illuminate\Http\JsonResponse                                        The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                              If there is an issue with deleting the accounts.
     */
    public function deleteAccounts(string $planComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $accountIds): \Illuminate\Http\JsonResponse;

    /**
     * Validate a Plan Comptable.
     *
     * @param  string                                   $planComptableId    The unique identifier of the Plan Comptable to validate.
     * @return \Illuminate\Http\JsonResponse                                The JSON response indicating the validation result.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                      If there is an issue with validating the Plan Comptable.
     */
    public function validatePlanComptable(string $planComptableId): \Illuminate\Http\JsonResponse;
}