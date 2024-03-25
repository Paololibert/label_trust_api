<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Finances\EcrituresComptable\Services\RESTful\Contracts\EcritureComptableRESTfulQueryServiceContract;

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

}