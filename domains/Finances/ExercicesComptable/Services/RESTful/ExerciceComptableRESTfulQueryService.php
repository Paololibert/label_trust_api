<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulQueryServiceContract;
use Illuminate\Http\Response;

/**
 * Class ***`ExerciceComptableRESTfulQueryService`***
 *
 * The `ExerciceComptableRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the ExercicesComptable module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `ExerciceComptableRESTfulQueryServiceContract` interface.
 *
 * The `ExerciceComptableRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying ExerciceComptable resources.
 *
 * @package ***`\Domains\Finances\ExercicesComptable\Services\RESTful`***
 */
class ExerciceComptableRESTfulQueryService extends RestJsonQueryService implements ExerciceComptableRESTfulQueryServiceContract
{
    /**
     * Constructor for the ExerciceComptableRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

    /**
     * Query la balance des comptes a une periode donnee
     *
     * @param  string                                           $exerciceComptableId                    The unique identifier of the exercice comptable accounts balance.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountsBalanceOfAPeriodeArrayData     Accounts balance array data.
     * @return \Illuminate\Http\JsonResponse                                                            The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                                  If there is an issue with quering accounts balance.
     */
    public function balanceDesComptes(string $exerciceComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $accountsBalanceOfAPeriodeArrayData): \Illuminate\Http\JsonResponse
    {
        try {

            $balance = $this->queryService->getRepository()->balanceDesComptes($exerciceComptableId, $accountsBalanceOfAPeriodeArrayData->toArray());

            return JsonResponseTrait::success(
                message: "Balance successfully query.",
                data: $balance,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to query balance of account of an exercice comptable: ' . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    
    /**
     * Query la balance des comptes a une periode donnee
     *
     * @param  string                                           $exerciceComptableId                    The unique identifier of the exercice comptable accounts balance.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountsBalanceOfAPeriodeArrayData     Accounts balance array data.
     * @return \Illuminate\Http\JsonResponse                                                            The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                                  If there is an issue with quering accounts balance.
     */
    public function balanceDeCompte(string $exerciceComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $data): \Illuminate\Http\JsonResponse
    {
        try {

            $balance = $this->queryService->getRepository()->balanceDeCompte($exerciceComptableId, $data->toArray());

            return JsonResponseTrait::success(
                message: "Balance successfully query.",
                data: $balance,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to query balance of account of an exercice comptable: ' . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
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
