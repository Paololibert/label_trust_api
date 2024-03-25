<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulReadWriteServiceContract;

/**
 * The ***`ExerciceComptableRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "ExerciceComptable" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "ExerciceComptable" resource.
 * It implements the `ExerciceComptableRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\ExercicesComptable\Services\RESTful`***
 */
class ExerciceComptableRESTfulReadWriteService extends RestJsonReadWriteService implements ExerciceComptableRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the ExerciceComptableRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}