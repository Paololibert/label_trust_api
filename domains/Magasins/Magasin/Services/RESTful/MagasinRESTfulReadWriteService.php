<?php

declare(strict_types=1);

namespace Domains\Magasins\Magasin\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Magasins\Magasin\Services\RESTful\Contracts\MagasinRESTfulReadWriteServiceContract;

/**
 * The ***`MagasinRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Magasin" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Magasin" resource.
 * It implements the `MagasinRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Magasins\Magasin\Services\RESTful`***
 */
class MagasinRESTfulReadWriteService extends RestJsonReadWriteService implements MagasinRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the MagasinRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}