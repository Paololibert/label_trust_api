<?php

declare(strict_types=1);

namespace Domains\Magasins\Commandes\Commande\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Magasins\Commandes\Commande\Services\RESTful\Contracts\CommandeRESTfulQueryServiceContract;

/**
 * Class ***`CommandeRESTfulQueryService`***
 *
 * The `CommandeRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the Commandes module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `CommandeRESTfulQueryServiceContract` interface.
 *
 * The `CommandeRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying Commande resources.
 *
 * @package ***`\Domains\Magasins\Commande\Services\RESTful`***
 */
class CommandeRESTfulQueryService extends RestJsonQueryService implements CommandeRESTfulQueryServiceContract
{
    /**
     * Constructor for the CommandeRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}