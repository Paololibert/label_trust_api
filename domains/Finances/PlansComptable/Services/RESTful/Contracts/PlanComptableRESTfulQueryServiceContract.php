<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;

/**
 * Interface ***`PlanComptableRESTfulQueryServiceContract`***
 *
 * The `PlanComptableRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to PlanComptable resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to PlanComptable resources.
 *
 * @package ***`\Domains\Finances\PlansComptable\Services\RESTful\Contracts`***
 */
interface PlanComptableRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{
    /**
     * Fetches the accounts associated with a specific Plan Comptable.
     *
     * Retrieves the accounts belonging to the Plan Comptable identified by the given ID.
     * Returns a JSON response containing information about the accounts associated with the Plan Comptable.
     *
     * @param  string                           $planComptableId    The unique identifier of the Plan Comptable to query accounts for.
     * @return \Illuminate\Http\JsonResponse                        The JSON response containing information about the accounts.
     *
     * @throws \Core\Utils\Exceptions\ServiceException              If there is an issue with the service operation.
     */
    public function fetchAccounts(string $planComptableId): \Illuminate\Http\JsonResponse;
}
