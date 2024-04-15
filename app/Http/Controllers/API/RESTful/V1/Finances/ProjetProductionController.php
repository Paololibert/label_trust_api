<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\RESTful\V1\Finances;

use App\Http\Requests\Finances\v1\ProjetsProduction\CreateProjetProductionRequest;
use App\Http\Requests\Finances\v1\ProjetsProduction\UpdateProjetProductionRequest;
use App\Http\Requests\ResourceRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Domains\Finances\EcrituresAnalytique\DataTransfertObjects\CreateEcritureAnalytiqueDTO;
use Domains\Finances\EcrituresAnalytique\Services\RESTful\Contracts\EcritureAnalytiqueRESTfulQueryServiceContract;
use Domains\Finances\EcrituresAnalytique\Services\RESTful\Contracts\EcritureAnalytiqueRESTfulReadWriteServiceContract;
use Domains\Finances\ExercicesComptable\DataTransfertObjects\PeriodeOfBalanceDTO;
use Domains\Finances\ProjetsProduction\Services\RESTful\Contracts\ProjetProductionRESTfulQueryServiceContract;
use Domains\Finances\ProjetsProduction\Services\RESTful\Contracts\ProjetProductionRESTfulReadWriteServiceContract;
use Domains\Finances\OperationsAnalytique\DataTransfertObjects\CreateOperationAnalytiqueDTO;
use Domains\Finances\OperationsAnalytique\DataTransfertObjects\UpdateOperationAnalytiqueDTO;
use Domains\Finances\OperationsAnalytique\Services\RESTful\Contracts\OperationAnalytiqueRESTfulQueryServiceContract;
use Domains\Finances\OperationsAnalytique\Services\RESTful\Contracts\OperationAnalytiqueRESTfulReadWriteServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * **`ProjetProductionController`**
 *
 * Controller for managing classe resources. This controller extends the RESTfulController
 * and provides CRUD operations for classe resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class ProjetProductionController extends RESTfulResourceController
{
    /**
     * @var EcritureAnalytiqueRESTfulQueryServiceContract
     */
    protected EcritureAnalytiqueRESTfulQueryServiceContract $ecritureAnalytiqueRESTfulQueryService;

    /**
     * @var EcritureAnalytiqueRESTfulReadWriteServiceContract
     */
    protected EcritureAnalytiqueRESTfulReadWriteServiceContract $ecritureAnalytiqueRESTfulReadWriteService;

    /**
     * @var OperationAnalytiqueRESTfulQueryAnalytiquetract
     */
    protected OperationAnalytiqueRESTfulQueryServiceContract $operationAnalytiqueRESTfulQueryService;

    /**
     * @var OperationAnalytiqueRESTfulReadWriteAnalytiquetract
     */
    protected OperationAnalytiqueRESTfulReadWriteServiceContract $operationAnalytiqueRESTfulReadWriteService;


    /**
     * Create a new ProjetProductionController instance.
     *
     * @param \Domains\ProjetsProduction\Services\RESTful\Contracts\ProjetProductionRESTfulReadWriteServiceContract $projetProductionRESTfulReadWriteService
     *        The ProjetProduction RESTful Query Service instance.
     * @param \Domains\ProjetsProduction\Services\RESTful\Contracts\ProjetProductionRESTfulQueryServiceContract $projetProductionRESTfulQueryService
     *        The ProjetProduction RESTful Query Service instance.
     */
    public function __construct(ProjetProductionRESTfulReadWriteServiceContract $projetProductionRESTfulReadWriteService, ProjetProductionRESTfulQueryServiceContract $projetProductionRESTfulQueryService, EcritureAnalytiqueRESTfulReadWriteServiceContract $ecritureAnalytiqueRESTfulReadWriteService, EcritureAnalytiqueRESTfulQueryServiceContract $ecritureAnalytiqueRESTfulQueryService, OperationAnalytiqueRESTfulReadWriteServiceContract $operationAnalytiqueRESTfulReadWriteService, OperationAnalytiqueRESTfulQueryServiceContract $operationAnalytiqueRESTfulQueryService)
    {
        parent::__construct($projetProductionRESTfulReadWriteService, $projetProductionRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateProjetProductionRequest::class);
        $this->setRequestClass('update', UpdateProjetProductionRequest::class);

        $this->ecritureAnalytiqueRESTfulQueryService         = $ecritureAnalytiqueRESTfulQueryService;
        $this->ecritureAnalytiqueRESTfulReadWriteService     = $ecritureAnalytiqueRESTfulReadWriteService;

        $this->operationAnalytiqueRESTfulQueryService       = $operationAnalytiqueRESTfulQueryService;
        $this->operationAnalytiqueRESTfulReadWriteService   = $operationAnalytiqueRESTfulReadWriteService;
    }

    /**
     * Fetch journal of an exercice comptable.
     *
     * @param  string                           $planComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the accounts fetched operation.
     */
    public function journaux(Request $request, string $exerciceComptableId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new PeriodeOfBalanceDTO]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        // Call the service method to add the accounts to the Plan Comptable
        return $this->restJsonQueryService->journaux($exerciceComptableId, $createRequest->getDto());
    }

    /**
     * Fetch balance of account of an exercice comptable.
     *
     * @param  string                           $planComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the accounts fetched operation.
     */
    public function journal(Request $request, string $exerciceComptableId, string $journalId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new PeriodeOfBalanceDTO]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        // Call the service method to add the accounts to the Plan Comptable
        return $this->restJsonQueryService->journal($exerciceComptableId, $journalId, $createRequest->getDto());
    }


    /**
     * Fetch ecritures comptable
     *
     * @param  string                           $exerciceComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the accounts fetched operation.
     */
    public function fetchEcrituresAnalytique(Request $request, string $exerciceComptableId, string $projetProductionId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new BaseDTO()]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        $createRequest->getDto()->setProperty("exercice_comptable_id", $exerciceComptableId);
        $createRequest->getDto()->setProperty("projet_production_id", $projetProductionId);

        return $this->ecritureAnalytiqueRESTfulQueryService->filter(filterCondition: $createRequest->getDto(), page: (int) $request->query('page', 1), perPage: (int) $request->query('perPage', 15), order: $request->query('order', 'asc'), orderBy: $request->query('sort', 'created_at'), columns: $request->query('columns', "[*]"));
    }

    /**
     * Register ecriture Comptable
     *
     * @param  string                           $exerciceComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                            The JSON response indicating the status of the accounts fetched operation.
     */
    public function registerANewEcritureAnalytique(Request $request, string $exerciceComptableId, string $projetProductionId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new CreateEcritureAnalytiqueDTO()]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        $createRequest->getDto()->setProperty("exercice_comptable_id", $exerciceComptableId);
        $createRequest->getDto()->setProperty("projet_production_id", $projetProductionId);

        // Call the service method to add the accounts to the Plan Comptable
        return $this->ecritureAnalytiqueRESTfulReadWriteService->create($createRequest->getDto());
    }


    /**
     * Fetch operations analytique of an exercice comptable.
     *
     * @param  string                           $exerciceComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the accounts fetched operation.
     */
    public function fetchOperationsAnalytique(Request $request, string $exerciceComptableId, string $projetProductionId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new BaseDTO()]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        $createRequest->getDto()->setProperty("exercice_comptable_id", $exerciceComptableId);
        $createRequest->getDto()->setProperty("projet_production_id", $projetProductionId);

        return $this->operationAnalytiqueRESTfulQueryService->filter(filterCondition: $createRequest->getDto(), page: (int) $request->query('page', 1), perPage: (int) $request->query('perPage', 15), order: $request->query('order', 'asc'), orderBy: $request->query('sort', 'created_at'), columns: $request->query('columns', "[*]"));
    }

    /**
     * Enregistrement d'une operation disponible
     *
     * @param  string                           $exerciceComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                            The JSON response indicating the status of the accounts fetched operation.
     */
    public function suiviAnalytique(Request $request, string $exerciceComptableId, string $projetProductionId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new CreateOperationAnalytiqueDTO()]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        $createRequest->getDto()->setProperty("exercice_comptable_id", $exerciceComptableId);
        $createRequest->getDto()->setProperty("projet_production_id", $projetProductionId);

        // Call the service method to add the accounts to the Plan Comptable
        return $this->operationAnalytiqueRESTfulReadWriteService->create($createRequest->getDto());
    }

    /**
     * Valider une operation disponible
     *
     * @param  string                           $exerciceComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                            The JSON response indicating the status of the accounts fetched operation.
     */
    public function validateOperationAnalytique(Request $request, string $exerciceComptableId, string $operationAnalytiqueId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new UpdateOperationAnalytiqueDTO]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        $createRequest->getDto()->setProperty("exercice_comptable_id", $exerciceComptableId);

        // Call the service method to add the accounts to the Plan Comptable
        return $this->operationAnalytiqueRESTfulReadWriteService->validateOperationComptable($operationAnalytiqueId, $createRequest->getDto());
    }
    
}