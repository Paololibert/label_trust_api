<?php

declare(strict_types=1);

namespace Domains\Magasins\StorageSpace\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Magasins\StorageSpace\Services\RESTful\Contracts\StorageSpaceRESTfulReadWriteServiceContract;

/**
 * The ***`StorageSpaceRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "StorageSpace" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "StorageSpace" resource.
 * It implements the `StorageSpaceRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Magasins\StorageSpace\Services\RESTful`***
 */
class StorageSpaceRESTfulReadWriteService extends RestJsonReadWriteService implements StorageSpaceRESTfulReadWriteServiceContract
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