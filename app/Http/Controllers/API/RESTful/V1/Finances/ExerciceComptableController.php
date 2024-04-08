<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\RESTful\V1\Finances;

use App\Http\Requests\Finances\v1\ExercicesComptable\CreateExerciceComptableRequest;
use App\Http\Requests\Finances\v1\ExercicesComptable\UpdateExerciceComptableRequest;
use App\Http\Requests\ResourceRequest;
use App\Rules\AccountNumberExistsInEitherTable;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\StatusExerciceEnum;
use Domains\Finances\EcrituresComptable\DataTransfertObjects\CreateEcritureComptableDTO;
use Domains\Finances\EcrituresComptable\Services\RESTful\Contracts\EcritureComptableRESTfulQueryServiceContract;
use Domains\Finances\EcrituresComptable\Services\RESTful\Contracts\EcritureComptableRESTfulReadWriteServiceContract;
use Domains\Finances\ExercicesComptable\DataTransfertObjects\PeriodeOfBalanceDTO;
use Domains\Finances\ExercicesComptable\DataTransfertObjects\ReportDeSoldeDTO;
use Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulQueryServiceContract;
use Domains\Finances\ExercicesComptable\Services\RESTful\Contracts\ExerciceComptableRESTfulReadWriteServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
     * Balance of an account of an exercice comptable.
     *
     * @param  string                           $planComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the accounts fetched operation.
     */
    public function balanceDeCompte(Request $request, string $exerciceComptableId): JsonResponse
    {
        $dto = new PeriodeOfBalanceDTO();

        $dto->setRules(["account_number" => ["required"]]);

        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => $dto]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        // Call the service method to add the accounts to the Plan Comptable
        return $this->restJsonQueryService->balanceDeCompte($exerciceComptableId, $createRequest->getDto());
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
     * Cloture des soldes aux comptes
     *
     * @param  string                           $exerciceComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                            The JSON response indicating the status of the accounts fetched operation.
     */
    public function cloture(Request $request, string $exerciceComptableId): JsonResponse
    {
        $exercice_comptable = $this->restJsonQueryService->getReadOnlyService()->findById($exerciceComptableId);

        if (!$exercice_comptable) {
            throw ValidationException::withMessages(["Exercice comptable inconnu"]);
        } else {
            if ($exercice_comptable->status_exercice === StatusExerciceEnum::CLOSE) {
                throw ValidationException::withMessages(["L'exercice comptable est deja cloturer"]);
            }
        }
        
        $dto = (new BaseDTO());
        
        $dto->setRules(["cloture_at" => ["required", "date_format:d/m/Y"]]);
        
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => $dto]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        // Call the service method to add the accounts to the Plan Comptable
        return $this->restJsonReadWriteService->clotureExercice($exerciceComptableId, $createRequest->getDto());
    }

    /**
     * Fetch balance of account of an exercice comptable.
     *
     * @param  string                           $planComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the accounts fetched operation.
     */
    public function fetchEcrituresComptable(Request $request, string $exerciceComptableId): JsonResponse
    {
        // Instantiate the ResourceRequest with a CreateAccountDTO instance
        $createRequest = app(ResourceRequest::class, ["dto" => new BaseDTO()]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        $createRequest->getDto()->setProperty("exercice_comptable_id", $exerciceComptableId);

        return $this->ecritureComptableRESTfulQueryService->filter(filterCondition: $createRequest->getDto(), page: (int) $request->query('page', 1), perPage: (int) $request->query('perPage', 15), order: $request->query('order', 'asc'), orderBy: $request->query('sort', 'created_at'), columns: $request->query('columns', "[*]"));
    }

    /**
     * Fetch balance of account of an exercice comptable.
     *
     * @param  string                           $planComptableId    The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                        The JSON response indicating the status of the accounts fetched operation.
     */
    public function fetchDetailsOfAnEcritureComptable(Request $request, string $exerciceComptableId, string $ecritureComptableId): JsonResponse
    {
        return $this->ecritureComptableRESTfulQueryService->retrieveDetailsOfEcritureComptable($ecritureComptableId, $exerciceComptableId);
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
        $createRequest = app(ResourceRequest::class, ["dto" => new CreateEcritureComptableDTO()]);

        // Validate the incoming request using the ResourceRequest rules
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        $createRequest->getDto()->setProperty("exercice_comptable_id", $exerciceComptableId);

        // Call the service method to add the accounts to the Plan Comptable
        return $this->ecritureComptableRESTfulReadWriteService->create($createRequest->getDto());
    }
}
