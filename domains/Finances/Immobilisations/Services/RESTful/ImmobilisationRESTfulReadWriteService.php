<?php

declare(strict_types=1);

namespace Domains\Finances\Immobilisations\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Finances\Immobilisations\Services\RESTful\Contracts\ImmobilisationRESTfulReadWriteServiceContract;

/**
 * The ***`ImmobilisationRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Immobilisation" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Immobilisation" resource.
 * It implements the `ImmobilisationRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\Immobilisations\Services\RESTful`***
 */
class ImmobilisationRESTfulReadWriteService extends RestJsonReadWriteService implements ImmobilisationRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the ImmobilisationRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}