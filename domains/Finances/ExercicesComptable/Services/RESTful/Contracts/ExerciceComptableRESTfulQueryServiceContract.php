<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;

/**
 * Interface ***`ExerciceComptableRESTfulQueryServiceContract`***
 *
 * The `ExerciceComptableRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to ExerciceComptable resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to ExerciceComptable resources.
 *
 * @package ***`\Domains\Finances\ExercicesComptable\Services\RESTful\Contracts`***
 */
interface ExerciceComptableRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{

    /**
     * Query la balance des comptes a une periode donnee
     *
     * @param  string                                           $exerciceComptableId                    The unique identifier of the exercice comptable accounts balance.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountsBalanceOfAPeriodeArrayData     Accounts balance array data.
     * @return \Illuminate\Http\JsonResponse                                                            The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                                  If there is an issue with quering accounts balance.
     */
    public function balanceDesComptes(string $exerciceComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $accountsBalanceOfAPeriodeArrayData): \Illuminate\Http\JsonResponse;
}