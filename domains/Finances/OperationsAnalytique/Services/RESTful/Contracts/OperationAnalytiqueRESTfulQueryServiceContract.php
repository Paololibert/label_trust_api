<?php

declare(strict_types=1);

namespace Domains\Finances\OperationsAnalytique\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;
use Core\Utils\DataTransfertObjects\DTOInterface;

/**
 * Interface ***`OperationAnalytiqueRESTfulQueryServiceContract`***
 *
 * The `OperationAnalytiqueRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to OperationAnalytique resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to OperationAnalytique resources.
 *
 * @package ***`\Domains\Finances\OperationsDisponible\Services\RESTful\Contracts`***
 */
interface OperationAnalytiqueRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{
    /**
     * Retrieve list of operation comptable.
     *
     * @param  array $exerciceComptableId               The criteria for filtering the records.
     * @param  array $columns                           The columns to select.
     * @return \Illuminate\Http\JsonResponse            The JSON response containing the collection of filtered records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException  If there is an error retrieving the filtered records.
     */
    public function filter(DTOInterface $filterCondition, int $page = 1, int $perPage = 15, string $orderBy, string $order, string $pageName = 'page', array $columns = ['*']): \Illuminate\Http\JsonResponse;


}