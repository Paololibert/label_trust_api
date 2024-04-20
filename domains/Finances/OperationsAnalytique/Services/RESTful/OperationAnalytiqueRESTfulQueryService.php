<?php

declare(strict_types=1);

namespace Domains\Finances\OperationsAnalytique\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\OperationsAnalytique\Services\RESTful\Contracts\OperationAnalytiqueRESTfulQueryServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class ***`OperationAnalytiqueRESTfulQueryService`***
 *
 * The `OperationAnalytiqueRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the OperationsAnalytique module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `OperationAnalytiqueRESTfulQueryServiceContract` interface.
 *
 * The `OperationAnalytiqueRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying OperationAnalytique resources.
 *
 * @package ***`\Domains\Finances\OperationsAnalytique\Services\RESTful`***
 */
class OperationAnalytiqueRESTfulQueryService extends RestJsonQueryService implements OperationAnalytiqueRESTfulQueryServiceContract
{
    /**
     * Constructor for the OperationAnalytiqueRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

    public function filter(DTOInterface $filterCondition, int $page = 1, int $perPage = 15, string $orderBy, string $order, string $pageName = 'page', array $columns = ['*']): JsonResponse
    {
        {
            try {
    
                $data = $filterCondition->toArray();
    
                $query = $this->queryService->getRepository()->getModel();
    
                /* if ($conditions) {
                    
                    foreach ($conditions as $filterName => $filter) {
                        if(!is_array($filter)){
                            $filter = ["where" => ["$filterName" => $filter]];
                        }
                        dump($filter);
                        foreach ($filter as $filterName => $condition) {
                            switch ($filterName) {
                                case 'in':
                                    $query = $query->whereIn($condition[0], $condition[1]);
                                    break;
                                case 'between':
                                    $query = $query->whereBetween($condition[0], $condition[1]);
                                    break;
    
                                default:
                                    $query = $query->where($condition[0], $condition[1], $condition[2]);
                                    break;
                            }
                        }
                    }
                } */
            
                $operation_analytique_disponible = $query->whereHas("exercice_comptable", function($query) use($data) {
                    $query->where("id", $data["exercice_comptable_id"]);
                })->orderBy($orderBy, $order)->paginate(perPage: $perPage, columns: explode(",", $columns[0]), pageName: $pageName, page: $page);
    
                return JsonResponseTrait::success(
                    message: "Operations analytique successfully query.",
                    data: $operation_analytique_disponible,
                    status_code: Response::HTTP_OK
                );
            } catch (CoreException $exception) {
                // Throw a ServiceException with an error message and the caught exception
                throw new ServiceException(message: 'Failed to query operation comptable disponible: ' . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
            }
        }
    }
}