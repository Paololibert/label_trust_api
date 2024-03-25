<?php

declare(strict_types=1);

namespace Domains\Finances\CategoriesDeCompte\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Finances\CategoriesDeCompte\Services\RESTful\Contracts\CategorieDeCompteRESTfulReadWriteServiceContract;

/**
 * The ***`CategorieDeCompteRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "CategorieDeCompte" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "CategorieDeCompte" resource.
 * It implements the `CategorieDeCompteRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\CategoriesDeCompte\Services\RESTful`***
 */
class CategorieDeCompteRESTfulReadWriteService extends RestJsonReadWriteService implements CategorieDeCompteRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the CategorieDeCompteRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}