<?php

declare(strict_types=1);

namespace Domains\Employees\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Employees\Services\RESTful\Contracts\EmployeeRESTfulReadWriteServiceContract;
use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Illuminate\Http\Response;

/**
 * The ***`EmployeeRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Employee" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Employee" resource.
 * It implements the `EmployeeRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Employees\Services\RESTful`***
 */
class EmployeeRESTfulReadWriteService extends RestJsonReadWriteService implements EmployeeRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the EmployeeRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}