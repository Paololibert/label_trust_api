<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Finances;

use App\Http\Requests\Finances\v1\ExercicesComptable\CreateExerciceComptableRequest;
use App\Http\Requests\Finances\v1\ExercicesComptable\UpdateExerciceComptableRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulQueryServiceContract;
use Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulReadWriteServiceContract;

/**
 * **`ExerciceComptableController`**
 *
 * Controller for managing classe resources. This controller extends the RESTfulController
 * and provides CRUD operations for classe resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class ExerciceComptableController extends RESTfulResourceController
{
    /**
     * Create a new ExerciceComptableController instance.
     *
     * @param \Domains\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulQueryServiceContract $compteDeExerciceComptableRESTfulQueryService
     *        The ExerciceComptable RESTful Query Service instance.
     */
    public function __construct(ExerciceComptableRESTfulReadWriteServiceContract $compteDeExerciceComptableRESTfulReadWriteService, ExerciceComptableRESTfulQueryServiceContract $compteDeExerciceComptableRESTfulQueryService)
    {
        parent::__construct($compteDeExerciceComptableRESTfulReadWriteService, $compteDeExerciceComptableRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateExerciceComptableRequest::class);
        $this->setRequestClass('update', UpdateExerciceComptableRequest::class);
    }
}
