<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\CategoriesOfEmployees\Services\RESTful\Contracts\CategoryOfEmployeeRESTfulQueryServiceContract;
use Illuminate\Http\Response;
use Throwable;

/**
 * Class ***`CategoryOfEmployeeRESTfulQueryService`***
 *
 * The `CategoryOfEmployeeRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the CategoriesOfEmployees module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `CategoryOfEmployeeRESTfulQueryServiceContract` interface.
 *
 * The `CategoryOfEmployeeRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying CategoryOfEmployee resources.
 *
 * @package ***`\Domains\CategoriesOfEmployees\Services\RESTful`***
 */
class CategoryOfEmployeeRESTfulQueryService extends RestJsonQueryService implements CategoryOfEmployeeRESTfulQueryServiceContract
{
    /**
     * Constructor for the CategoryOfEmployeeRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

    /**
     * Retrieve taux associated with a specific CategoryOfEmployee.
     *
     * This method queries the system to fetch the taux linked to a particular CategoryOfEmployee. The response
     * is returned as a JSON format, providing details about the taux granted to the specified CategoryOfEmployee.
     *
     * @param   string                                  $categoryEmployeeId The unique identifier of the CategoryOfEmployee to query taux for.
     * 
     * @return  \Illuminate\Http\JsonResponse                               The JSON response containing information about the taux associated with the CategoryOfEmployee.
     * 
     * @throws  \Core\Utils\Exceptions\ServiceException                     Throws an exception if there is an issue with the service operation.
     */
    public function fetchCategoryOfEmployeeTaux(string $categoryEmployeeId): \Illuminate\Http\JsonResponse
    {
        try {

            // Query the system to retrieve taux associated with the specified category of employee ID
            $taux = $this->queryService->findById($categoryEmployeeId)->taux;

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