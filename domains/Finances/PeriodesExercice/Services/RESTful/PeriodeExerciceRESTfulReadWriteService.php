<?php

declare(strict_types=1);

namespace Domains\Finances\PeriodesExercice\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Finances\PeriodesExercice\Services\RESTful\Contracts\PeriodeExerciceRESTfulReadWriteServiceContract;

/**
 * The ***`PeriodeExerciceRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "PeriodeExercice" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "PeriodeExercice" resource.
 * It implements the `PeriodeExerciceRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\PeriodesExercice\Services\RESTful`***
 */
class PeriodeExerciceRESTfulReadWriteService extends RestJsonReadWriteService implements PeriodeExerciceRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the PeriodeExerciceRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}