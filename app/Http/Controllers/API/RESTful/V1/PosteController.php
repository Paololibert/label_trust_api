<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1;

use App\Http\Requests\Postes\v1\CreatePosteRequest;
use App\Http\Requests\Postes\v1\UpdatePosteRequest;
use App\Http\Requests\ResourceRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Postes\PosteSalaries\DataTransfertObjects\CreatePosteSalaryDTO;
use Domains\Postes\PosteSalaries\DataTransfertObjects\PosteSalaryDTO;
use Domains\Postes\Services\RESTful\Contracts\PosteRESTfulQueryServiceContract;
use Domains\Postes\Services\RESTful\Contracts\PosteRESTfulReadWriteServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * **`PosteController`**
 *
 * Controller for managing poste resources. This controller extends the RESTfulController
 * and provides CRUD operations for poste resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class PosteController extends RESTfulResourceController
{
    /**
     * Create a new PosteController instance.
     *
     * @param \Domains\Postes\Services\RESTful\Contracts\PosteRESTfulQueryServiceContract $posteRESTfulQueryService
     *        The Poste RESTful Query Service instance.
     */
    public function __construct(PosteRESTfulReadWriteServiceContract $posteRESTfulReadWriteService, PosteRESTfulQueryServiceContract $posteRESTfulQueryService)
    {
        parent::__construct($posteRESTfulReadWriteService, $posteRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreatePosteRequest::class);
        $this->setRequestClass('update', UpdatePosteRequest::class);
    }

    /**
     * Assign User privileges to a user.
     *
     * @param  Request $request The request object containing the data for updating the resource.
     * @param  string                                     $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the role privileges granted operation.
     */
    public function attachSalariesToAPoste(Request $request, string $id): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ["dto" => new CreatePosteSalaryDTO]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }
        
        return $this->restJsonReadWriteService->attachSalariesToAPoste($id, $createRequest->getDto());
    }

    /**
     * Revoke role privileges from a user.
     *
     * @param  Request $request The request object containing the data for updating the resource.
     * @param  string                                     $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the role privileges revoked operation.
     */
    public function detachSalariesFromAPoste(Request $request, string $id): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ["dto" => new PosteSalaryDTO]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        return $this->restJsonReadWriteService->detachSalariesFromAPoste($id, $createRequest->getDto());
    }

    /**
     * Fetch user granted role privileges.
     *
     * @param  string                                     $id      The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the role privileges fetched operation.
     */
    public function fetchPosteSalaries(string $id): JsonResponse
    {
        return $this->restJsonQueryService->fetchPosteSalaries($id);
    }
}
