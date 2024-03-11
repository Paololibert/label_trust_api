<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\Services\RESTful\Contracts\CategoryOfEmployeeTauxRESTfulReadWriteServiceContract;

/**
 * The ***`CategoryOfEmployeeTauxRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "CategoryOfEmployeeTaux" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "CategoryOfEmployeeTaux" resource.
 * It implements the `CategoryOfEmployeeTauxRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\Services\RESTful`***
 */
class CategoryOfEmployeeTauxRESTfulReadWriteService extends RestJsonReadWriteService implements CategoryOfEmployeeTauxRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the CategoryOfEmployeeTauxRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}