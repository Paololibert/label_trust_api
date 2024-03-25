<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Finances\EcrituresComptable\Services\RESTful\Contracts\EcritureComptableRESTfulReadWriteServiceContract;

/**
 * The ***`EcritureComptableRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "EcritureComptable" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "EcritureComptable" resource.
 * It implements the `EcritureComptableRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\EcrituresComptable\Services\RESTful`***
 */
class EcritureComptableRESTfulReadWriteService extends RestJsonReadWriteService implements EcritureComptableRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the EcritureComptableRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}