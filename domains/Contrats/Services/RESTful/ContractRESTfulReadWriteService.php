<?php

declare(strict_types=1);

namespace Domains\Contrats\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Contrats\Services\RESTful\Contracts\ContractRESTfulReadWriteServiceContract as ContractsContractRESTfulReadWriteServiceContract;

/**
 * The ***`ContractRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Contract" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Contract" resource.
 * It implements the `ContractRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Contrats\Services\RESTful`***
 */
class ContractRESTfulReadWriteService extends RestJsonReadWriteService implements ContractsContractRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the ContractRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }
}