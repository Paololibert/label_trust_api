<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\PlansComptable\Accounts\Services\RESTful\Contracts\AccountRESTfulQueryServiceContract;
use Illuminate\Http\Response;
use Throwable;

/**
 * Class ***`AccountRESTfulQueryService`***
 *
 * The `AccountRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the Accounts module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `AccountRESTfulQueryServiceContract` interface.
 *
 * The `AccountRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying Account resources.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\Services\RESTful`***
 */
class AccountRESTfulQueryService extends RestJsonQueryService implements AccountRESTfulQueryServiceContract
{
    /**
     * Constructor for the AccountRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }


    /**
     * Fetches sub-accounts information for a specific account within a given plan comptable.
     *
     * @param string                                    $planComptableId    The unique identifier of the plan comptable to query sub-accounts for.
     * @param string                                    $accountId          The unique identifier of the account to query sub-accounts for.
     * @param string                                    $subAccountId       The unique identifier of the sub-account to query.
     * 
     * @return \Illuminate\Http\JsonResponse                                The JSON response containing information about the sub-account.
     * 
     * @throws \Core\Utils\Exceptions\ServiceException                      Throws an exception if there is an issue with the service operation.
     */
    public function fetchSubAccounts(string $planComptableId, string $accountId, string $subAccountId): \Illuminate\Http\JsonResponse
    {
        try {

            // Query the system to retrieve taux associated with the specified category of employee ID
            $taux = []; //$this->queryService->findById($accountId)->p->taux;

            // Check if data is present to customize the message.
            $message = empty($taux) ? 'No taux found for the category of employee.' : 'Taux fetched successfully for the category of employee';

            return JsonResponseTrait::success(
                message: $message,
                data: $taux,
                status_code: Response::HTTP_OK
            );
        } catch (Throwable $exception) {
            // Throw a ServiceException if there is an issue with the service operation
            throw new ServiceException(message: 'Failed to fetch taux for category of employee: ' . $exception->getMessage(), previous: $exception);
        }
    }

}