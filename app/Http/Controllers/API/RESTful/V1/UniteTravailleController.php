<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1;

use App\Http\Requests\ResourceRequest;
use App\Http\Requests\UniteTravailles\v1\CreateUniteTravailleRequest;
use App\Http\Requests\UniteTravailles\v1\UpdateUniteTravailleRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\TauxAndSalaries\DataTransfertObjects\CreateTauxAndSalaryDTO;
use Domains\TauxAndSalaries\DataTransfertObjects\TauxAndSalaryDTO;
use Domains\TauxAndSalaries\DataTransfertObjects\UpdateTauxAndSalaryDTO;
use Domains\UniteTravailles\Services\RESTful\Contracts\UniteTravailleRESTfulQueryServiceContract;
use Domains\UniteTravailles\Services\RESTful\Contracts\UniteTravailleRESTfulReadWriteServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * **`UniteTravailleController`**
 *
 * Controller for managing poste resources. This controller extends the RESTfulController
 * and provides CRUD operations for poste resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class UniteTravailleController extends RESTfulResourceController
{
    /**
     * Create a new UniteTravailleController instance.
     *
     * @param \Domains\UniteTravailles\Services\RESTful\Contracts\UniteTravailleRESTfulQueryServiceContract $posteRESTfulQueryService
     *        The UniteTravaille RESTful Query Service instance.
     */
    public function __construct(UniteTravailleRESTfulReadWriteServiceContract $uniteTravailleRESTfulReadWriteService, UniteTravailleRESTfulQueryServiceContract $uniteTravailleRESTfulQueryService)
    {
        parent::__construct($uniteTravailleRESTfulReadWriteService, $uniteTravailleRESTfulQueryService);


        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateUniteTravailleRequest::class);
        $this->setRequestClass('update', UpdateUniteTravailleRequest::class);
    }

    /**
     * Add taux to unite travailles.
     *
     * @param  Request                          $request The request object containing the data for updating the resource.
     * @param  string                           $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse             The JSON response indicating the status of the access grant operation.
     */
    public function addTaux(Request $request, string $id): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ['dto' => new CreateTauxAndSalaryDTO]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());

            return $this->restJsonReadWriteService->addTaux($id, $createRequest->getDto());
        }
    }

    /**
     * Edit taux for unite travailles.
     *
     * @param  Request                          $request The request object containing the data for updating the resource.
     * @param  string                           $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse             The JSON response indicating the status of the access grant operation.
     */
    public function editTaux(Request $request, string $id): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ['dto' => new UpdateTauxAndSalaryDTO]);

        if ($createRequest) {
            
            $createRequest->validate($createRequest->rules());

            return $this->restJsonReadWriteService->editTaux($id, $createRequest->getDto());
        }
    }

    /**
     * Revoke access to a role.
     *
     * @param  Request $request The request object containing the data for updating the resource.
     * @param  string                                     $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the access grant operation.
     */
    public function removeTaux(Request $request, string $id): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ['dto' => new TauxAndSalaryDTO]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());

            return $this->restJsonReadWriteService->removeTaux($id, $createRequest->getDto());
        }
    }
}
