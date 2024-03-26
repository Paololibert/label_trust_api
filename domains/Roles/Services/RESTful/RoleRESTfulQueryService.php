<?php

declare(strict_types=1);

namespace Domains\Roles\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Roles\Services\RESTful\Contracts\RoleRESTfulQueryServiceContract;
use Illuminate\Http\Response;
use Throwable;

/**
 * Class ***`RoleRESTfulQueryService`***
 *
 * The `RoleRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the Roles module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `RoleRESTfulQueryServiceContract` interface.
 *
 * The `RoleRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying Role resources.
 *
 * @package ***`\Domains\Roles\Services\RESTful`***
 */
class RoleRESTfulQueryService extends RestJsonQueryService implements RoleRESTfulQueryServiceContract
{
    /**
     * Constructor for the RoleRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

    /**
     * Fetch access granted to a role.
     *
     * @param string $roleId The identifier of the role for which access will be fetched.
     * 
     * @return \Illuminate\Http\JsonResponse The JSON response containing the access granted to the role.
     * 
     * @throws \Core\Utils\Exceptions\ServiceException If there is an issue with the service operation.
     */
    public function fetchRoleAccess(string $roleId): \Illuminate\Http\JsonResponse
    {
        try {
            $roleAccess = $this->queryService->findById($roleId)->permissions;

            // Check if data is present to customize the message.
            $message = empty($roleAccess) ? 'No role access found.' : 'Role access fetched successfully';

            return JsonResponseTrait::success(
                message: $message,
                data: $roleAccess,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {
            
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to fetched role access: ' . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}