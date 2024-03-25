<?php

declare(strict_types=1);

namespace Domains\Finances\Journaux\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Domains\Finances\Journaux\Services\RESTful\Contracts\JournalRESTfulQueryServiceContract;

/**
 * Class ***`JournalRESTfulQueryService`***
 *
 * The `JournalRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the Journaux module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `JournalRESTfulQueryServiceContract` interface.
 *
 * The `JournalRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying Journal resources.
 *
 * @package ***`\Domains\Finances\Journaux\Services\RESTful`***
 */
class JournalRESTfulQueryService extends RestJsonQueryService implements JournalRESTfulQueryServiceContract
{
    /**
     * Constructor for the JournalRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

}