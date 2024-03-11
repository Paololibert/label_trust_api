<?php

declare(strict_types=1);

namespace Domains\Postes\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;

/**
 * Interface ***`PosteRESTfulQueryServiceContract`***
 *
 * The `PosteRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to Poste resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to Poste resources.
 *
 * @package ***`\Domains\Postes\Services\RESTful\Contracts`***
 */
interface PosteRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{
    /**
     * Retrieve salries associated with a specific poste.
     *
     * This method queries the system to fetch the salries linked to a particular poste. The response
     * is returned as a JSON format, providing details about the salries granted to the specified poste.
     *
     * @param   string                                  $posteId    The unique identifier of the poste to query taux for.
     * 
     * @return  \Illuminate\Http\JsonResponse                       The JSON response containing information about the taux associated with the poste.
     * 
     * @throws  \Core\Utils\Exceptions\ServiceException             Throws an exception if there is an issue with the service operation.
     */
    public function fetchPosteSalaries(string $posteId): \Illuminate\Http\JsonResponse;

}