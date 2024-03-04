<?php

declare(strict_types=1);

namespace Domains\Permissions\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Permissions\Services\RESTful\Contracts\PermissionRESTfulReadWriteServiceContract;

/**
 * The ***`PermissionRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Permission" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Permission" resource.
 * It implements the `PermissionRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Permissions\Services\RESTful`***
 */
class PermissionRESTfulReadWriteService extends RestJsonReadWriteService implements PermissionRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the PermissionRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }
}