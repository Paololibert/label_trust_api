<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;

/**
 * Interface ***`EcritureComptableRESTfulQueryServiceContract`***
 *
 * The `EcritureComptableRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to EcritureComptable resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to EcritureComptable resources.
 *
 * @package ***`\Domains\Finances\EcrituresComptable\Services\RESTful\Contracts`***
 */
interface EcritureComptableRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{
    /**
     * Retrieve list of ecritures comptable.
     *
     * @param  array $exerciceComptableId               The criteria for filtering the records.
     * @param  array $columns                           The columns to select.
     * @return \Illuminate\Http\JsonResponse            The JSON response containing the collection of filtered records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException  If there is an error retrieving the filtered records.
     */
    public function ecritures_comptable(string $exerciceComptableId, array $columns = ['*']): \Illuminate\Http\JsonResponse;

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
    public function retrieveDetailsOfEcritureComptable(string $exerciceComptableId, $ecritureComptablId, array $columns = ['*']): \Illuminate\Http\JsonResponse;
}
