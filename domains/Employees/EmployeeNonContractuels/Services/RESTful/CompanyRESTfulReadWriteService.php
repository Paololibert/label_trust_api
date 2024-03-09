<?php

declare(strict_types=1);

namespace Domains\Users\Companies\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Users\Companies\Services\RESTful\Contracts\CompanyRESTfulReadWriteServiceContract;

/**
 * The ***`CompanyRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Company" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Company" resource.
 * It implements the `CompanyRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Users\Companies\Services\RESTful`***
 */
class CompanyRESTfulReadWriteService extends RestJsonReadWriteService implements CompanyRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the CompanyRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }
}