<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Finances;

use App\Http\Requests\Finances\v1\Immobilisations\CreateImmobilisationRequest;
use App\Http\Requests\Finances\v1\Immobilisations\UpdateImmobilisationRequest;
use App\Http\Requests\ResourceRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Finances\Immobilisations\Services\RESTful\Contracts\ImmobilisationRESTfulQueryServiceContract;
use Domains\Finances\Immobilisations\Services\RESTful\Contracts\ImmobilisationRESTfulReadWriteServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * **`ImmobilisationController`**
 *
 * Controller for managing classe resources. This controller extends the RESTfulController
 * and provides CRUD operations for classe resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class ImmobilisationController extends RESTfulResourceController
{
    /**
     * Create a new ImmobilisationController instance.
     *
     * @param \Domains\Immobilisations\Services\RESTful\Contracts\ImmobilisationRESTfulQueryServiceContract $classeDeCompteRESTfulQueryService
     *        The Immobilisation RESTful Query Service instance.
     */
    public function __construct(ImmobilisationRESTfulReadWriteServiceContract $classeDeCompteRESTfulReadWriteService, ImmobilisationRESTfulQueryServiceContract $classeDeCompteRESTfulQueryService)
    {
        parent::__construct($classeDeCompteRESTfulReadWriteService, $classeDeCompteRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateImmobilisationRequest::class);
        $this->setRequestClass('update', UpdateImmobilisationRequest::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request The request object containing the data for creating the resource.
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating the status of the operation.
     */
    public function store(Request $request): JsonResponse
    { 
        $createRequest = app(CreateImmobilisationRequest::class, [$request]);

        if ($createRequest) {

            $createRequest->validate($createRequest->rules());

            $createRequest->getDto()->setProperty("exercice_comptable_id", $request->route("exercice_comptable_id"));
        
            return $this->restJsonReadWriteService->create($createRequest->getDto());
        }
    }
}