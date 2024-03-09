<?php

declare(strict_types=1);

namespace Domains\TauxAndSalaries\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\TauxAndSalaries\Services\RESTful\Contracts\TauxAndSalaryRESTfulReadWriteServiceContract;

/**
 * The ***`TauxAndSalaryRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "TauxAndSalary" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "TauxAndSalary" resource.
 * It implements the `TauxAndSalaryRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\TauxAndSalaries\Services\RESTful`***
 */
class TauxAndSalaryRESTfulReadWriteService extends RestJsonReadWriteService implements TauxAndSalaryRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the TauxAndSalaryRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}