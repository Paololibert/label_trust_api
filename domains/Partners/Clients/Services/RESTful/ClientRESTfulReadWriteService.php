<?php

declare(strict_types=1);

namespace Domains\Partners\Clients\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Partners\Clients\Services\RESTful\Contracts\ClientRESTfulReadWriteServiceContract as ContractsClientRESTfulReadWriteServiceContract;


/**
 * The ***`ClientRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Clients" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Clients" resource.
 * It implements the `ClientRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Partners\Clients\Services\RESTful`***
 */
class ClientRESTfulReadWriteService extends RestJsonReadWriteService implements ContractsClientRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the ClientRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
        
    }

}