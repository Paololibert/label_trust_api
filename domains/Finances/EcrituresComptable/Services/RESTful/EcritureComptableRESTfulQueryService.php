<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\EcrituresComptable\Services\RESTful\Contracts\EcritureComptableRESTfulQueryServiceContract;
use Illuminate\Http\Response;

/**
 * Class ***`EcritureComptableRESTfulQueryService`***
 *
 * The `EcritureComptableRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the EcrituresComptable module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `EcritureComptableRESTfulQueryServiceContract` interface.
 *
 * The `EcritureComptableRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying EcritureComptable resources.
 *
 * @package ***`\Domains\Finances\EcrituresComptable\Services\RESTful`***
 */
class EcritureComptableRESTfulQueryService extends RestJsonQueryService implements EcritureComptableRESTfulQueryServiceContract
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
     * Retrieve data based on the provided query criteria.
     *
     * @param  array $exerciceComptableId                   The criteria for filtering the records.
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of filtered records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error retrieving the filtered records.
     */
    public function ecritures_comptable(string $exerciceComptableId, array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {

            $ecritures_comptable = $this->queryService->findById($exerciceComptableId)/* ->ecritures_comptable */;
        
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


    /**
     * Retrieve details of an ecritures comptable.
     *
     * @param  array $exerciceComptableId               The criteria for filtering the records.
     * @param  array $ecritureComptablId               The criteria for filtering the records.
     * @param  array $columns                           The columns to select.
     * @return \Illuminate\Http\JsonResponse            The JSON response containing the collection of filtered records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException  If there is an error retrieving the filtered records.
     */
    public function retrieveDetailsOfEcritureComptable(string $exerciceComptableId, $ecritureComptablId, array $columns = ['*']): \Illuminate\Http\JsonResponse
    {

        try {

            $ecriture_comptable = $this->queryService->findById($exerciceComptableId)->ecritures_comptable()->where("id", $ecritureComptablId)->first();
        
            return JsonResponseTrait::success(
                message: "Ecriture comptable successfully query.",
                data: $ecriture_comptable,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to query balance of account of an exercice comptable: ' . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}