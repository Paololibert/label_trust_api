<?php

declare(strict_types=1);

namespace Domains\Postes\PosteSalaries\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Postes\PosteSalaries\Services\RESTful\Contracts\PosteSalaryRESTfulReadWriteServiceContract;

/**
 * The ***`PosteSalaryRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "PosteSalary" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "PosteSalary" resource.
 * It implements the `PosteSalaryRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Postes\PosteSalaries\Services\RESTful`***
 */
class PosteSalaryRESTfulReadWriteService extends RestJsonReadWriteService implements PosteSalaryRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the PosteSalaryRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}