<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\PlansComptable\Accounts\Services\RESTful\Contracts\AccountRESTfulReadWriteServiceContract;
use Illuminate\Http\Response;
use Throwable;

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
        try {

            // Logic to delete accounts from the specified Plan Comptable
            $result = $this->readWriteService->getRepository()->deleteSubAccounts($accountId, $accountIds->toArray()['comptes'], ["where" => [["plan_comptable_id", "=", $planComptableId]]]);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to detach accounts from the Plan Comptable. The accounts were not detach.", 1);
            }

            return JsonResponseTrait::success(
                message: 'Sub Accounts deleted successfully from a plan comptable account.',
                data: $result,
                status_code: Response::HTTP_OK
            );
        } catch (Throwable $exception) {
            // Throw a ServiceException if there is an issue with deleting the sub-accounts
            throw new ServiceException(message: 'Failed to delete sub-accounts from a plan comptable account: ' . $exception->getMessage(), previous: $exception);
        }
    }

}