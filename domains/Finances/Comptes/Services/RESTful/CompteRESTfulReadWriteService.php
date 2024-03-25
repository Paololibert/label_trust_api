<?php

declare(strict_types=1);

namespace Domains\Finances\Comptes\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Finances\Comptes\Services\RESTful\Contracts\CompteRESTfulReadWriteServiceContract;

/**
 * The ***`CompteRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Compte" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Compte" resource.
 * It implements the `CompteRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\Comptes\Services\RESTful`***
 */
class CompteRESTfulReadWriteService extends RestJsonReadWriteService implements CompteRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the CompteRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}