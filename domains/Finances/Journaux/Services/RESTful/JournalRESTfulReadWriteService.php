<?php

declare(strict_types=1);

namespace Domains\Finances\Journaux\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Finances\Journaux\Services\RESTful\Contracts\JournalRESTfulReadWriteServiceContract;

/**
 * The ***`JournalRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Journal" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Journal" resource.
 * It implements the `JournalRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\Journaux\Services\RESTful`***
 */
class JournalRESTfulReadWriteService extends RestJsonReadWriteService implements JournalRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the JournalRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}