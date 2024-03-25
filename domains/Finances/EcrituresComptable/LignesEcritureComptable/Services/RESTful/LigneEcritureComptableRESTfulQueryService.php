<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\LignesEcritureComptable\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Finances\EcrituresComptable\LignesEcritureComptable\Services\RESTful\Contracts\LigneEcritureComptableRESTfulQueryServiceContract;

/**
 * Class ***`LigneEcritureComptableRESTfulQueryService`***
 *
 * The `LigneEcritureComptableRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the EcrituresComptable module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `LigneEcritureComptableRESTfulQueryServiceContract` interface.
 *
 * The `LigneEcritureComptableRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying LigneEcritureComptable resources.
 *
 * @package ***`\Domains\Finances\EcrituresComptable\LignesEcritureComptable\Services\RESTful`***
 */
class LigneEcritureComptableRESTfulQueryService extends RestJsonQueryService implements LigneEcritureComptableRESTfulQueryServiceContract
{
    /**
     * Constructor for the LigneEcritureComptableRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}