<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`ExerciceComptableRESTfulReadWriteServiceContract`***
 *
 * The `ExerciceComptableRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the ExercicesComptable module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on ExerciceComptable resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Finances\ExercicesComptable\Services\RESTful\Contracts`***
 */
interface ExerciceComptableRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
    /**
     * Report de solde aux comptes
     *
     * @param  string                                           $exerciceComptableId        The unique identifier of the exercice comptable accounts balance will be report.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountsBalanceArrayData   Accounts balance array data.
     * @return \Illuminate\Http\JsonResponse                                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                      If there is an issue with reporting accounts balance.
     */
    public function reportDesSoldesAuxComptes(string $exerciceComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $accountsBalanceArrayData): \Illuminate\Http\JsonResponse;

    /**
     * Cloture de l'exercice
     *
     * @param  string                                           $exerciceComptableId        The unique identifier of the exercice comptable accounts balance will be report.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountsBalanceArrayData   Accounts balance array data.
     * @return \Illuminate\Http\JsonResponse                                                The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                      If there is an issue with reporting accounts balance.
     */
    public function clotureExercice(string $exerciceComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $data): \Illuminate\Http\JsonResponse;
}