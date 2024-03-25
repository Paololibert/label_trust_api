<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Finances;

use App\Http\Requests\Finances\v1\PeriodesExercice\CreatePeriodeExerciceRequest;
use App\Http\Requests\Finances\v1\PeriodesExercice\UpdatePeriodeExerciceRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Finances\PeriodesExercice\Services\RESTful\Contracts\PeriodeExerciceRESTfulQueryServiceContract;
use Domains\Finances\PeriodesExercice\Services\RESTful\Contracts\PeriodeExerciceRESTfulReadWriteServiceContract;

/**
 * **`PeriodeExerciceController`**
 *
 * Controller for managing classe resources. This controller extends the RESTfulController
 * and provides CRUD operations for classe resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class PeriodeExerciceController extends RESTfulResourceController
{
    /**
     * Create a new PeriodeExerciceController instance.
     *
     * @param \Domains\PeriodesExercice\Services\RESTful\Contracts\PeriodeExerciceRESTfulQueryServiceContract $compteDePeriodeExerciceRESTfulQueryService
     *        The PeriodeExercice RESTful Query Service instance.
     */
    public function __construct(PeriodeExerciceRESTfulReadWriteServiceContract $compteDePeriodeExerciceRESTfulReadWriteService, PeriodeExerciceRESTfulQueryServiceContract $compteDePeriodeExerciceRESTfulQueryService)
    {
        parent::__construct($compteDePeriodeExerciceRESTfulReadWriteService, $compteDePeriodeExerciceRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreatePeriodeExerciceRequest::class);
        $this->setRequestClass('update', UpdatePeriodeExerciceRequest::class);
    }
}
