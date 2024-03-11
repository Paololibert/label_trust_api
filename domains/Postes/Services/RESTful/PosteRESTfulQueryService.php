<?php

declare(strict_types=1);

namespace Domains\Postes\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Postes\Services\RESTful\Contracts\PosteRESTfulQueryServiceContract;
use Illuminate\Http\Response;
use Throwable;

/**
 * Class ***`PosteRESTfulQueryService`***
 *
 * The `PosteRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the Postes module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `PosteRESTfulQueryServiceContract` interface.
 *
 * The `PosteRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying Poste resources.
 *
 * @package ***`\Domains\Postes\Services\RESTful`***
 */
class PosteRESTfulQueryService extends RestJsonQueryService implements PosteRESTfulQueryServiceContract
{
    /**
     * Constructor for the PosteRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

    /**
     * Retrieve salaries associated with a specific poste.
     *
     * This method queries the system to fetch the salaries linked to a particular poste. The response
     * is returned as a JSON format, providing details about the salaries granted to the specified poste.
     *
     * @param   string                                  $posteId    The unique identifier of the poste to query taux for.
     * 
     * @return  \Illuminate\Http\JsonResponse                       The JSON response containing information about the taux associated with the poste.
     * 
     * @throws  \Core\Utils\Exceptions\ServiceException             Throws an exception if there is an issue with the service operation.
     */
    public function fetchPosteSalaries(string $posteId): \Illuminate\Http\JsonResponse
    {
        try {

            // Query the system to retrieve salaries associated with the specified poste ID
            $salaries = $this->queryService->findById($posteId)->salaries;

            // Check if data is present to customize the message.
            $message = empty($salaries) ? 'No salaries found for the poste.' : 'Salaries fetched successfully for the poste';

            return JsonResponseTrait::success(
                message: $message,
                data: $salaries,
                status_code: Response::HTTP_OK
            );
        } catch (Throwable $exception) {
            // Throw a ServiceException if there is an issue with the service operation
            throw new ServiceException(message: 'Failed to fetch salaries for the poste: ' . $exception->getMessage(), previous: $exception);
        }
    }

}