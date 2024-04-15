<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulReadWriteServiceContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * The ***`ExerciceComptableRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "ExerciceComptable" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "ExerciceComptable" resource.
 * It implements the `ExerciceComptableRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\ExercicesComptable\Services\RESTful`***
 */
class ExerciceComptableRESTfulReadWriteService extends RestJsonReadWriteService implements ExerciceComptableRESTfulReadWriteServiceContract
{    
    /**
     * Constructor for the ExerciceComptableRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

    /**
     * Report de solde aux comptes
     *
     * @param  string                                           $exerciceComptableId        The unique identifier of the exercice comptable accounts balance will be report.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountsBalanceArrayData   Accounts balance array data.
     * @return \Illuminate\Http\JsonResponse                                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                      If there is an issue with reporting accounts balance.
     */
    public function reportDesSoldesAuxComptes(string $exerciceComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $accountsBalanceArrayData): \Illuminate\Http\JsonResponse{

        // Begin the transaction
        DB::beginTransaction();
        
        try {
            //
            $result = $this->readWriteService->getRepository()->reportDesSoldesAuxComptes(exerciceComptableId: $exerciceComptableId, accountsDataArray: $accountsBalanceArrayData->toArray()['accounts']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to report accounts balances.", 1);
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Soldes reporter aux comptes.',
                data: $result,
                status_code: Response::HTTP_CREATED
            );
        } catch (CoreException $exception) {
            // Throw a ServiceException if there is an issue with adding the accounts
            throw new ServiceException(message: "Failed to add accounts records to a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }


    /**
     * Cloture de l'exercice
     *
     * @param  string                                           $exerciceComptableId        The unique identifier of the exercice comptable accounts balance will be report.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $data   Accounts balance array data.
     * @return \Illuminate\Http\JsonResponse                                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                      If there is an issue with reporting accounts balance.
     */
    public function clotureExercice(string $exerciceComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $data): \Illuminate\Http\JsonResponse{

        // Begin the transaction
        DB::beginTransaction();
        
        try {
            //
            $result = $this->readWriteService->getRepository()->clotureDesComptesDunExercice(exerciceComptableId: $exerciceComptableId, data: $data->toArray());

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to close the exercice.", 1);
            }

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Exercice Cloturer.',
                data: $result,
                status_code: Response::HTTP_CREATED
            );
        } catch (CoreException $exception) {
            // Throw a ServiceException if there is an issue with adding the accounts
            throw new ServiceException(message: "Failed to add accounts records to a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}