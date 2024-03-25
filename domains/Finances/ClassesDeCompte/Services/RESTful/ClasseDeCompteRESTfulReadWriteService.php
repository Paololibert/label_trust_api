<?php

declare(strict_types=1);

namespace Domains\Finances\ClassesDeCompte\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Finances\ClassesDeCompte\Services\RESTful\Contracts\ClasseDeCompteRESTfulReadWriteServiceContract;

/**
 * The ***`ClasseDeCompteRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "ClasseDeCompte" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "ClasseDeCompte" resource.
 * It implements the `ClasseDeCompteRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\ClassesDeCompte\Services\RESTful`***
 */
class ClasseDeCompteRESTfulReadWriteService extends RestJsonReadWriteService implements ClasseDeCompteRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the ClasseDeCompteRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}