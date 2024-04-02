<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Finances;

use App\Http\Requests\Finances\v1\ExercicesComptable\CreateExerciceComptableRequest;
use App\Http\Requests\Finances\v1\ExercicesComptable\UpdateExerciceComptableRequest;
use App\Http\Requests\ResourceRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Finances\EcrituresComptable\DataTransfertObjects\CreateEcritureComptableDTO;
use Domains\Finances\EcrituresComptable\Services\RESTful\Contracts\EcritureComptableRESTfulQueryServiceContract;
use Domains\Finances\EcrituresComptable\Services\RESTful\Contracts\EcritureComptableRESTfulReadWriteServiceContract;
use Domains\Finances\ExercicesComptable\DataTransfertObjects\PeriodeOfBalanceDTO;
use Domains\Finances\ExercicesComptable\DataTransfertObjects\ReportDeSoldeDTO;
use Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulQueryServiceContract;
use Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulReadWriteServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @var EcritureComptableRESTfulQueryServiceContract
     */
    protected EcritureComptableRESTfulQueryServiceContract $ecritureComptableRESTfulQueryService;

    /**
     * @var EcritureComptableRESTfulReadWriteServiceContract
     */
    protected EcritureComptableRESTfulReadWriteServiceContract $ecritureComptableRESTfulReadWriteService;

    /**
     * Create a new ExerciceComptableController instance.
     *
     * @param \Domains\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulQueryServiceContract $compteDeExerciceComptableRESTfulQueryService
     *        The ExerciceComptable RESTful Query Service instance.
     */
    public function __construct(ExerciceComptableRESTfulReadWriteServiceContract $exerciceComptableRESTfulReadWriteService, ExerciceComptableRESTfulQueryServiceContract $exerciceComptableRESTfulQueryService, EcritureComptableRESTfulReadWriteServiceContract $ecritureComptableRESTfulReadWriteService, EcritureComptableRESTfulQueryServiceContract $ecritureComptableRESTfulQueryService)
    {
        parent::__construct($exerciceComptableRESTfulReadWriteService, $exerciceComptableRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateExerciceComptableRequest::class);
        $this->setRequestClass('update', UpdateExerciceComptableRequest::class);

        $this->ecritureComptableRESTfulQueryService = $ecritureComptableRESTfulQueryService;
        $this->ecritureComptableRESTfulReadWriteService = $ecritureComptableRESTfulReadWriteService;
    }

    /**
     * Fetch balance of account of an exercice comptable.
     *
     * @param  string                           $planComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the accounts fetched operation.
     */
    public function balanceDesComptes(Request $request, string $exerciceComptableId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new PeriodeOfBalanceDTO]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        // Call the service method to add the accounts to the Plan Comptable
        return $this->restJsonQueryService->balanceDesComptes($exerciceComptableId, $createRequest->getDto());
    }

    /**
     * Report des soldes aux comptes
     *
     * @param  string                           $exerciceComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                            The JSON response indicating the status of the accounts fetched operation.
     */
    public function reportDesSoldesAuxComptes(Request $request, string $exerciceComptableId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new ReportDeSoldeDTO]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        // Call the service method to add the accounts to the Plan Comptable
        return $this->restJsonReadWriteService->reportDesSoldesAuxComptes($exerciceComptableId, $createRequest->getDto());
    }

    /**
     * Fetch balance of account of an exercice comptable.
     *
     * @param  string                           $planComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the accounts fetched operation.
     */
    public function fetchEcrituresComptable(Request $request, string $exerciceComptableId): JsonResponse
    {
        return $this->ecritureComptableRESTfulQueryService->where(["exercice_comptable_id", $exerciceComptableId]);
    }

    /**
     * Fetch balance of account of an exercice comptable.
     *
     * @param  string                           $planComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the accounts fetched operation.
     */
    public function fetchDetailsOfAnEcritureComptable(Request $request, string $exerciceComptableId, string $ecritureComptableId): JsonResponse
    {
        return $this->ecritureComptableRESTfulQueryService->retrieveDetailsOfEcritureComptable($exerciceComptableId, $ecritureComptableId);
    }

    /**
     * Report des soldes aux comptes
     *
     * @param  string                           $exerciceComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                            The JSON response indicating the status of the accounts fetched operation.
     */
    public function registerANewEcritureComptable(Request $request, string $exerciceComptableId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new CreateEcritureComptableDTO]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        $createRequest->getDto()->setProperty("exercice_comptable_id", $exerciceComptableId) ;

        // Call the service method to add the accounts to the Plan Comptable
        return $this->ecritureComptableRESTfulReadWriteService->create($createRequest->getDto());
    }
}
