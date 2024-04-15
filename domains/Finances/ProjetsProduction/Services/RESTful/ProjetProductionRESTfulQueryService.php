<?php

declare(strict_types=1);

namespace Domains\Finances\ProjetsProduction\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\ProjetsProduction\Services\RESTful\Contracts\ProjetProductionRESTfulQueryServiceContract;
use Illuminate\Http\Response;

/**
 * Class ***`ProjetProductionRESTfulQueryService`***
 *
 * The `ProjetProductionRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the ProjetsProduction module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `ProjetProductionRESTfulQueryServiceContract` interface.
 *
 * The `ProjetProductionRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying ProjetProduction resources.
 *
 * @package ***`\Domains\Finances\ProjetsProduction\Services\RESTful`***
 */
class ProjetProductionRESTfulQueryService extends RestJsonQueryService implements ProjetProductionRESTfulQueryServiceContract
{
    /**
     * Constructor for the ProjetProductionRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

    /**
     * Query les journaux
     *
     * @param  string                                           $exerciceComptableId                    The unique identifier of the exercice comptable accounts balance.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountsBalanceOfAPeriodeArrayData     Accounts balance array data.
     * @return \Illuminate\Http\JsonResponse                                                            The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                                  If there is an issue with quering accounts balance.
     */
    public function journaux(string $exerciceComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $accountsBalanceOfAPeriodeArrayData): \Illuminate\Http\JsonResponse
    {
        try {

            $balance = $this->queryService->getRepository()->journaux($exerciceComptableId, $accountsBalanceOfAPeriodeArrayData->toArray());

            return JsonResponseTrait::success(
                message: "Successfully query.",
                data: $balance,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to query balance of account of an exercice comptable: ' . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Query un journal
     *
     * @param  string                                           $exerciceComptableId                    The unique identifier of the exercice comptable accounts balance.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountsBalanceOfAPeriodeArrayData     Accounts balance array data.
     * @return \Illuminate\Http\JsonResponse                                                            The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                                  If there is an issue with quering accounts balance.
     */
    public function journal(string $exerciceComptableId, string $journalId, \Core\Utils\DataTransfertObjects\DTOInterface $accountsBalanceOfAPeriodeArrayData): \Illuminate\Http\JsonResponse
    {
        try {

            $balance = $this->queryService->getRepository()->journal($exerciceComptableId, $journalId, $accountsBalanceOfAPeriodeArrayData->toArray());

            return JsonResponseTrait::success(
                message: "Journal des comptes successfully query.",
                data: $balance,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to query balance of account of an exercice comptable: ' . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
