<?php

declare(strict_types=1);

namespace Domains\Finances\ProjetsProduction\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;

/**
 * Interface ***`ProjetProductionRESTfulQueryServiceContract`***
 *
 * The `ProjetProductionRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to ProjetProduction resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to ProjetProduction resources.
 *
 * @package ***`\Domains\Finances\ProjetsProduction\Services\RESTful\Contracts`***
 */
interface ProjetProductionRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{
    /**
     * Query les journaux
     *
     * @param  string                                           $exerciceComptableId                    The unique identifier of the exercice comptable accounts balance.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountsBalanceOfAPeriodeArrayData     Accounts balance array data.
     * @return \Illuminate\Http\JsonResponse                                                            The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                                  If there is an issue with quering accounts balance.
     */
    public function journaux(string $exerciceComptableId, \Core\Utils\DataTransfertObjects\DTOInterface $data): \Illuminate\Http\JsonResponse;

    /**
     * Query un journal
     *
     * @param  string                                           $exerciceComptableId                    The unique identifier of the exercice comptable accounts balance.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $accountsBalanceOfAPeriodeArrayData     Accounts balance array data.
     * @return \Illuminate\Http\JsonResponse                                                            The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                                                  If there is an issue with quering accounts balance.
     */
    public function journal(string $exerciceComptableId, string $journalId, \Core\Utils\DataTransfertObjects\DTOInterface $data): \Illuminate\Http\JsonResponse;
}