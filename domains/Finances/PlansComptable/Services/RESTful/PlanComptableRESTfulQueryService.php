<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Services\RESTful;

use App\Http\Resources\Finances\PlanComptableResource;
use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\PlansComptable\Services\RESTful\Contracts\PlanComptableRESTfulQueryServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Class ***`PlanComptableRESTfulQueryService`***
 *
 * The `PlanComptableRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the PlansComptable module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `PlanComptableRESTfulQueryServiceContract` interface.
 *
 * The `PlanComptableRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying PlanComptable resources.
 *
 * @package ***`\Domains\Finances\PlansComptable\Services\RESTful`***
 */
class PlanComptableRESTfulQueryService extends RestJsonQueryService implements PlanComptableRESTfulQueryServiceContract
{
    /**
     * Constructor for the PlanComptableRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

    /**
     * Find a record by its ID.
     *
     * @param  Model|string                     $id             The ID of the record.
     * @param  array                            $columns        The columns to select.
     * @return \Illuminate\Http\JsonResponse                    The JSON response containing the found record, or null if not found.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error finding the record.
     */
    public function findById($id, array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {
            $plan = $this->queryService->findById($id, $columns)->load(["sortAccounts" => function ($query) use ($columns) {
                $query/* 
                ->select(["classes_de_compte.intitule", "classes_de_compte.class_number", DB::raw('count(plan_comptable_comptes.classe_id) as count'),])
                ->join('classes_de_compte', 'plan_comptable_comptes.classe_id', '=', 'classes_de_compte.id')
                    ->orderBy('classes_de_compte.class_number', 'ASC')
                    ->groupBy(['classes_de_compte.class_number', 'classes_de_compte.intitule']) */
                    //->ordoring()->without(["sous_comptes"])->withSousComptes(true)
                    /* ->groupBy(["classe.class_number", "classe.intitule"]) */;
            }]);

            return JsonResponseTrait::success(data: new PlanComptableResource($plan));
        } catch (CoreException $exception) {
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), previous: $exception);
        }
    }

    /**
     * Fetches the accounts associated with a specific Plan Comptable.
     *
     * Retrieves the accounts belonging to the Plan Comptable identified by the given ID.
     * Returns a JSON response containing information about the accounts associated with the Plan Comptable.
     *
     * @param  string                           $planComptableId    The unique identifier of the Plan Comptable to query accounts for.
     * @return \Illuminate\Http\JsonResponse                        The JSON response containing information about the accounts.
     *
     * @throws \Core\Utils\Exceptions\ServiceException              If there is an issue with fetching the accounts.
     */
    public function fetchAccounts(string $planComptableId): \Illuminate\Http\JsonResponse
    {
        try {
            // Query the system to retrieve accounts associated with the specified Plan Comptable ID
            $accounts = $this->queryService->findById($planComptableId)->accounts;

            // Check if data is present to customize the message.
            $message = empty($accounts) ? 'No accounts found for the Plan Comptable.' : 'Accounts fetched successfully for the Plan Comptable';

            return JsonResponseTrait::success(
                message: $message,
                data: $accounts,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Throw a ServiceException if there is an issue with fetching the accounts
            throw new ServiceException(message: "Failed to fetch accounts records from a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Fetches the accounts associated with a specific Plan Comptable.
     *
     * Retrieves the accounts belonging to the Plan Comptable identified by the given ID.
     * Returns a JSON response containing information about the accounts associated with the Plan Comptable.
     *
     * @param  string                                   $planComptableId    The unique identifier of the Plan Comptable to query accounts for.
     * @param  string                                   $accountId          The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                                The JSON response containing information about the accounts.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                      If there is an issue with fetching the sub-accounts.
     */
    public function fetchSubAccounts(string $planComptableId, $accountId): \Illuminate\Http\JsonResponse
    {
        try {
            // Query the system to retrieve accounts associated with the specified Plan Comptable ID
            $accounts = $this->queryService->findById($planComptableId)->accounts->where("id", $accountId)->first()->sous_comptes;

            // Check if data is present to customize the message.
            $message = empty($accounts) ? 'No sub accounts found for an account of the Plan Comptable.' : 'Sub-Accounts of an account fetched successfully.';

            return JsonResponseTrait::success(
                message: $message,
                data: $accounts,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Throw a ServiceException if there is an issue with fetching the accounts
            throw new ServiceException(message: "Failed to fetch accounts records from a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
