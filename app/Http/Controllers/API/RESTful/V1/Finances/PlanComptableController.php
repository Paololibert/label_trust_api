<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\RESTful\V1\Finances;

use App\Http\Requests\Finances\v1\PlansComptable\CreatePlanComptableRequest;
use App\Http\Requests\Finances\v1\PlansComptable\UpdatePlanComptableRequest;
use App\Http\Requests\ResourceRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Finances\Comptes\DataTransfertObjects\CompteDTO;
use Domains\Finances\PlansComptable\Accounts\DataTransfertObjects\CreateAccountDTO;
use Domains\Finances\PlansComptable\Accounts\DataTransfertObjects\UpdateAccountDTO;
use Domains\Finances\PlansComptable\Services\RESTful\Contracts\PlanComptableRESTfulQueryServiceContract;
use Domains\Finances\PlansComptable\Services\RESTful\Contracts\PlanComptableRESTfulReadWriteServiceContract;
use Domains\Finances\PlansComptable\Accounts\Services\RESTful\Contracts\AccountRESTfulReadWriteServiceContract;
use Domains\Finances\PlansComptable\Accounts\Services\RESTful\Contracts\AccountRESTfulQueryServiceContract;
use Domains\Finances\PlansComptable\Accounts\SubAccounts\DataTransfertObjects\CreateSubAccountDTO;
use Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful\Contracts\SubAccountRESTfulReadWriteServiceContract;
use Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful\Contracts\SubAccountRESTfulQueryServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * **`PlanComptableController`**
 *
 * Controller for managing classe resources. This controller extends the RESTfulController
 * and provides CRUD operations for classe resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class PlanComptableController extends RESTfulResourceController
{
    /**
     * @var AccountRESTfulQueryServiceContract
     */
    protected AccountRESTfulQueryServiceContract $accountRESTfulQueryService;

    /**
     * @var AccountRESTfulReadWriteServiceContract
     */
    protected AccountRESTfulReadWriteServiceContract $accountRESTfulReadWriteService;

    /**
     * Create a new PlanComptableController instance.
     *
     * @param \Domains\Finances\PlansComptable\Services\RESTful\Contracts\PlanComptableRESTfulReadWriteServiceContract $planComptableRESTfulReadWriteService
     *        The PlanComptable RESTful Read-Write Service instance.
     * @param \Domains\Finances\PlansComptable\Services\RESTful\Contracts\PlanComptableRESTfulQueryServiceContract $planComptableRESTfulQueryService
     *        The PlanComptable RESTful Query Service instance.
     * 
     * @param \Domains\Finances\PlansComptable\Accounts\Services\RESTful\Contracts\AccountRESTfulReadWriteServiceContract $accountRESTfulReadWriteService
     *        The Account RESTful Read-Write Service instance.
     * @param \Domains\Finances\PlansComptable\Accounts\Services\RESTful\Contracts\AccountRESTfulQueryServiceContract $accountRESTfulQueryService
     *        The Account RESTful Query Service instance.
     * 
     * @param \Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful\Contracts\SubAccountRESTfulReadWriteServiceContract $subAccountRESTfulReadWriteService
     *        The SubAccount RESTful Read-Write Service instance.
     * @param \Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful\Contracts\SubAccountRESTfulQueryServiceContract $subAccountRESTfulQueryService
     *        The SubAccount RESTful Query Service instance.
     */
    public function __construct(PlanComptableRESTfulReadWriteServiceContract $planComptableRESTfulReadWriteService, PlanComptableRESTfulQueryServiceContract $planComptableRESTfulQueryService, AccountRESTfulReadWriteServiceContract $accountRESTfulReadWriteService, AccountRESTfulQueryServiceContract $accountRESTfulQueryService, SubAccountRESTfulReadWriteServiceContract $subAccountRESTfulReadWriteService, SubAccountRESTfulQueryServiceContract $subAccountRESTfulQueryService)
    {
        parent::__construct($planComptableRESTfulReadWriteService, $planComptableRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreatePlanComptableRequest::class);
        $this->setRequestClass('update', UpdatePlanComptableRequest::class);

        $this->accountRESTfulQueryService = $accountRESTfulQueryService;
        $this->accountRESTfulReadWriteService = $accountRESTfulReadWriteService;
    }

    /**
     * Fetch plan comptable accounts.
     *
     * @param  string                           $planComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the accounts fetched operation.
     */
    public function fetchAccounts(Request $request, string $planComptableId): JsonResponse
    {
        return $this->restJsonQueryService->fetchAccounts($planComptableId);
    }

    /**
     * Add new accounts to a Plan Comptable.
     *
     * @param  Request                          $request            The request object containing the data for updating the resource.
     * @param  string                           $planComptableId    The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the operation.
     */
    public function addNewAccountsToPlan(Request $request, string $planComptableId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new CreateAccountDTO]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        // Call the service method to add the accounts to the Plan Comptable
        return $this->restJsonReadWriteService->addAccounts($planComptableId, $createRequest->getDto());
    }

    /**
     * Update accounts in a Plan Comptable.
     *
     * @param  Request                          $request            The request object containing the data for updating the resource.
     * @param  string                           $planComptableId    The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the operation.
     */
    public function updateAccountsInPlan(Request $request, string $planComptableId): JsonResponse
    {
        // Instantiate the ResourceRequest with a UpdateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new UpdateAccountDTO]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        // Call the service method to add the accounts to the Plan Comptable
        return $this->restJsonReadWriteService->updateAccounts($planComptableId, $createRequest->getDto());
    }

    /**
     * Delete accounts from a Plan Comptable.
     *
     * @param  Request                          $request            The request object containing the data for deleting the accounts.
     * @param  string                           $planComptableId    The identifier of the Plan Comptable from which accounts will be deleted.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the operation.
     */
    public function deleteAccountsFromPlan(Request $request, string $planComptableId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CompteDTO instance
        $deleteRequest = app(ResourceRequest::class, ["dto" => new CompteDTO]);

        // Validate the incoming request using the ResourceRequest rules
        if ($deleteRequest) {
            $deleteRequest->validate($deleteRequest->rules());
        }

        // Call the service method to delete the accounts from the Plan Comptable
        return $this->restJsonReadWriteService->deleteAccounts($planComptableId, $deleteRequest->getDto());
    }

    /**
     * Validate a plan comptable.
     *
     * @param  string                           $planComptableId    The identifier of the resource details that will be validate.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the comptable plan validation operation.
     */
    public function validatePlanComptable(string $planComptableId): JsonResponse
    {
        return $this->restJsonReadWriteService->validatePlanComptable($planComptableId);
    }

    /**
     * Fetch a plan comptable account sub accounts.
     *
     * @param  string                           $planComptableId    The identifier of the resource details that will be fetch.
     * @param  string                           $accountId          The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the sub accounts fetched operation.
     */
    public function fetchSubAccountsOfAPlanAccount(Request $request, string $planComptableId, string $accountId): JsonResponse
    {
        return $this->restJsonQueryService->fetchSubAccounts($planComptableId, $accountId);
    }

    /**
     * Add new sub-accounts to a plan comptable account.
     *
     * @param  Request                          $request            The request object containing the data for deleting the accounts.
     * @param  string                           $planComptableId    The identifier of the Plan Comptable from which accounts will be deleted.
     * @param  string                           $accountId          The identifier of an account in a specific Plan Comptable from which sub-accounts will be deleted.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the operation.
     */
    public function addNewAccountsToAPlanAccount(Request $request, string $planComptableId, string $accountId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new CreateSubAccountDTO]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        // Call the service method to add the accounts to the Plan Comptable
        return $this->accountRESTfulReadWriteService->addNewSubAccountsToAPlanAccount($planComptableId, $accountId, $createRequest->getDto());
    }

    /**
     * Delete sub-accounts from a plan comptable account.
     *
     * @param  Request                          $request            The request object containing the data for deleting the accounts.
     * @param  string                           $planComptableId    The identifier of the Plan Comptable from which accounts will be deleted.
     * @param  string                           $accountId          The identifier of an account in a specific Plan Comptable from which sub-accounts will be deleted.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the operation.
     */
    public function deleteSubAccountsFromAPlanAccount(Request $request, string $planComptableId, string $accountId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CompteDTO instance
        $deleteRequest = app(ResourceRequest::class, ["dto" => new CompteDTO]);

        // Validate the incoming request using the ResourceRequest rules
        if ($deleteRequest) {
            $deleteRequest->validate($deleteRequest->rules());
        }

        // Call the service method to delete the accounts from the Plan Comptable
        return $this->accountRESTfulReadWriteService->deleteSubAccountsFromAPlanAccount($planComptableId, $accountId, $deleteRequest->getDto());
    }
}
