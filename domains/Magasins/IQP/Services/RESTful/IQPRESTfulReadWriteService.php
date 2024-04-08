<?php

declare(strict_types=1);

namespace Domains\Magasins\IQP\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Magasins\IQP\Services\RESTful\Contracts\IQPRESTfulReadWriteServiceContract;

/**
 * The ***`IQPRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "IQP" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "IQP" resource.
 * It implements the `IQPRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Magasins\IQP\Services\RESTful`***
 */
class IQPRESTfulReadWriteService extends RestJsonReadWriteService implements IQPRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the IQPRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}