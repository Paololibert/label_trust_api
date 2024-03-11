<?php

declare(strict_types=1);

namespace Domains\Montants\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Montants\Services\RESTful\Contracts\MontantRESTfulReadWriteServiceContract;

/**
 * The ***`MontantRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Montant" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Montant" resource.
 * It implements the `MontantRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Montants\Services\RESTful`***
 */
class MontantRESTfulReadWriteService extends RestJsonReadWriteService implements MontantRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the MontantRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}