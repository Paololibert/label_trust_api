<?php

declare(strict_types=1);

namespace Domains\Devises\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Devises\Services\RESTful\Contracts\DeviseRESTfulReadWriteServiceContract;

/**
 * The ***`DeviseRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Devise" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Devise" resource.
 * It implements the `DeviseRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Devises\Services\RESTful`***
 */
class DeviseRESTfulReadWriteService extends RestJsonReadWriteService implements DeviseRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the DeviseRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}