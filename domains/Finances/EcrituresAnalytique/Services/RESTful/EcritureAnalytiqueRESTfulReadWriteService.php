<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresAnalytique\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Finances\EcrituresAnalytique\Services\RESTful\Contracts\EcritureAnalytiqueRESTfulReadWriteServiceContract;

/**
 * The ***`EcritureAnalytiqueRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "EcritureAnalytique" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "EcritureAnalytique" resource.
 * It implements the `EcritureAnalytiqueRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\EcrituresAnalytique\Services\RESTful`***
 */
class EcritureAnalytiqueRESTfulReadWriteService extends RestJsonReadWriteService implements EcritureAnalytiqueRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the EcritureAnalytiqueRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}