<?php

declare(strict_types=1);

namespace Domains\Finances\OperationsDisponible\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Finances\OperationsDisponible\Services\RESTful\Contracts\OperationDisponibleRESTfulReadWriteServiceContract;

/**
 * The ***`OperationDisponibleRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "OperationDisponible" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "OperationDisponible" resource.
 * It implements the `OperationDisponibleRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\OperationsDisponible\Services\RESTful`***
 */
class OperationDisponibleRESTfulReadWriteService extends RestJsonReadWriteService implements OperationDisponibleRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the OperationDisponibleRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}