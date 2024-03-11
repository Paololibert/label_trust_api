<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\RESTful\V1;

use App\Http\Requests\ResourceRequest;
use App\Http\Requests\Roles\v1\CreateRoleRequest;
use App\Http\Requests\Roles\v1\UpdateRoleRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Permissions\DataTransfertObjects\PermissionDTO;
use Domains\Roles\Services\RESTful\Contracts\RoleRESTfulQueryServiceContract;
use Illuminate\Http\JsonResponse;
use Domains\Roles\Services\RESTful\Contracts\RoleRESTfulReadWriteServiceContract;
use Illuminate\Http\Request;

/**
 * **`RoleController`**
 *
 * Controller for managing role resources. This controller extends the RESTfulController
 * and provides CRUD operations for role resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class RoleController extends RESTfulResourceController
{
    /**
     * Create a new RoleController instance.
     *
     * @param \Domains\Role\Services\RESTful\Contracts\RoleRESTfulReadWriteServiceContract $roleRESTfulReadWriteService
     *        The Role RESTful Read-Write Service instance.
     */
    public function __construct(RoleRESTfulReadWriteServiceContract $roleRESTfulReadWriteService, RoleRESTfulQueryServiceContract $roleRESTfulQueryService)
    {
        parent::__construct($roleRESTfulReadWriteService, $roleRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateRoleRequest::class);
        $this->setRequestClass('update', UpdateRoleRequest::class);
    }

    /**
     * Grant access to a role.
     *
     * @param  Request $request The request object containing the data for updating the resource.
     * @param  string                                     $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the access grant operation.
     */
    public function grantAccess(Request $request, string $id): JsonResponse
    {

        $createRequest = app(ResourceRequest::class, ['dto' => new PermissionDTO()]);
        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        return $this->restJsonReadWriteService->grantAccess($id, $createRequest->getDto());
    }

    /**
     * Revoke access to a role.
     *
     * @param  Request $request The request object containing the data for updating the resource.
     * @param  string                                     $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the access grant operation.
     */
    public function revokeAccess(Request $request, string $id): JsonResponse
    {

        $createRequest = app(ResourceRequest::class, ['dto' => new PermissionDTO]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        return $this->restJsonReadWriteService->revokeAccess($id, $createRequest->getDto());
    }

    /**
     * Revoke access to a role.
     *
     * @param  string                                     $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the access grant operation.
     */
    public function fetchRoleAccess(string $id): JsonResponse
    {
        return $this->restJsonQueryService->fetchRoleAccess($id);
    }
}
