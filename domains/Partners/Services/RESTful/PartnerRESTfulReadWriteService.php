<?php

declare(strict_types=1);

namespace Domains\Partners\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Partners\Services\RESTful\Contracts\PartnerRESTfulReadWriteServiceContract;

/**
 * The ***`PartnerRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Partner" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Partner" resource.
 * It implements the `PartnerRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Partners\Services\RESTful`***
 */
class PartnerRESTfulReadWriteService extends RestJsonReadWriteService implements PartnerRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the PartnerRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}