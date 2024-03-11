<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1;

use App\Http\Requests\ResourceRequest;
use App\Http\Requests\Users\v1\CreateUserRequest;
use App\Http\Requests\Users\v1\UpdateUserRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Roles\DataTransfertObjects\RoleDTO;
use Domains\Users\Services\RESTful\Contracts\UserRESTfulQueryServiceContract;
use Illuminate\Http\JsonResponse;
use Domains\Users\Services\RESTful\Contracts\UserRESTfulReadWriteServiceContract;
use Illuminate\Http\Request;

/**
 * **`UserController`**
 *
 * Controller for managing user resources. This controller extends the RESTfulController
 * and provides CRUD operations for user resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class UserController extends RESTfulResourceController
{
    /**
     * Create a new UserController instance.
     *
     * @param \Domains\User\Services\RESTful\Contracts\UserRESTfulReadWriteServiceContract $userRESTfulReadWriteService
     *        The User RESTful Read-Write Service instance.
     */
    public function __construct(UserRESTfulReadWriteServiceContract $userRESTfulReadWriteService, UserRESTfulQueryServiceContract $userRESTfulQueryService)
    {
        parent::__construct($userRESTfulReadWriteService, $userRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateUserRequest::class);
        $this->setRequestClass('update', UpdateUserRequest::class);
    }

    /**
     * Assign User privileges to a user.
     *
     * @param  Request $request The request object containing the data for updating the resource.
     * @param  string                                     $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the role privileges granted operation.
     */
    public function assignRolePrivileges(Request $request, string $id): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ['dto' => new RoleDTO]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }
        
        return $this->restJsonReadWriteService->assignRolePrivileges($id, $createRequest->getDto());
    }

    /**
     * Revoke role privileges from a user.
     *
     * @param  Request $request The request object containing the data for updating the resource.
     * @param  string                                     $id      The identifier of the resource to be updated.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the role privileges revoked operation.
     */
    public function revokeRolePrivileges(Request $request, string $id): JsonResponse
    {
        $createRequest = app(ResourceRequest::class, ['dto' => new RoleDTO]);

        if ($createRequest) {
            $createRequest->validate($createRequest->rules());
        }

        return $this->restJsonReadWriteService->revokeRolePrivileges($id, $createRequest->getDto());
    }

    /**
     * Fetch user granted role privileges.
     *
     * @param  string                                     $id      The identifier of the resource details that will be fetch.
     * @return \Illuminate\Http\JsonResponse                       The JSON response indicating the status of the role privileges fetched operation.
     */
    public function fetchUserRoles(string $id): JsonResponse
    {
        return $this->restJsonQueryService->fetchUserRoles($id);
    }

}
