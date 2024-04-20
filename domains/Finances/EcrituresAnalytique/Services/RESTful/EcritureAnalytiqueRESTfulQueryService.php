<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresAnalytique\Services\RESTful;

use App\Http\Resources\Finances\EcritureComptableCollection;
use App\Http\Resources\Finances\EcritureComptableResource;
use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\EcrituresAnalytique\Services\RESTful\Contracts\EcritureAnalytiqueRESTfulQueryServiceContract;
use Illuminate\Http\Response;

/**
 * Class ***`EcritureAnalytiqueRESTfulQueryService`***
 *
 * The `EcritureAnalytiqueRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the EcrituresAnalytique module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `EcritureAnalytiqueRESTfulReadWriteServiceContract` interface.
 *
 * The `EcritureAnalytiqueRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying EcritureAnalytique resources.
 *
 * @package ***`\Domains\Finances\EcrituresAnalytique\Services\RESTful`***
 */
class EcritureAnalytiqueRESTfulQueryService extends RestJsonQueryService implements EcritureAnalytiqueRESTfulQueryServiceContract
{
    /**
     * Constructor for the EcritureComptableRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }
    
    /**
     * Retrieve list of ecritures comptable.
     *
     * @param  array $exerciceComptableId               The criteria for filtering the records.
     * @param  array $columns                           The columns to select.
     * @return \Illuminate\Http\JsonResponse            The JSON response containing the collection of filtered records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException  If there is an error retrieving the filtered records.
     */
    public function filter(DTOInterface $filterCondition, int $page = 1, int $perPage = 15, string $orderBy, string $order, string $pageName = 'page', array $columns = ['*']): \Illuminate\Http\JsonResponse
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

            $ecritures_comptable = $query->whereHas("exercice_comptable_journal", function($query) use($data) {
                $query->where("exercice_comptable_id", $data["exercice_comptable_id"]);
            })->orderBy($orderBy, $order)->paginate(perPage: $perPage, columns: explode(",", $columns[0]), pageName: $pageName, page: $page);

            return JsonResponseTrait::success(
                message: "Ecriture comptable successfully query.",
                data: $ecritures_comptable,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to query balance of account of an exercice comptable: ' . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}