<?php

declare(strict_types=1);

namespace Domains\Users\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Users\Services\RESTful\Contracts\UserRESTfulQueryServiceContract;
use Illuminate\Http\Response;
use Throwable;

/**
 * Class ***`UserRESTfulQueryService`***
 *
 * The `UserRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the Users module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `UserRESTfulQueryServiceContract` interface.
 *
 * The `UserRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying User resources.
 *
 * @package ***`\Domains\Users\Services\RESTful`***
 */
class UserRESTfulQueryService extends RestJsonQueryService implements UserRESTfulQueryServiceContract
{
    /**
     * Constructor for the UserRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

    /**
     * Get all records.
     *
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of all records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error retrieving the records.
     */
    public function all(array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(message: "", data: $this->queryService->all($columns));
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Fetch user granted role privileges.
     *
     * @param string $userId The identifier of the user for which role will be fetched.
     * 
     * @return \Illuminate\Http\JsonResponse The JSON response containing the role granted to a user.
     * 
     * @throws \Core\Utils\Exceptions\ServiceException If there is an issue with the service operation.
     */
    public function fetchUserRoles(string $userId): \Illuminate\Http\JsonResponse
    {
        try {
            $user_roles = $this->queryService->findById($userId)->roles;

            // Check if data is present to customize the message.
            $message = empty($user_roles) ? 'No granted role found.' : 'User granted roles fetched successfully';

            return JsonResponseTrait::success(
                message: $message,
                data: $user_roles,
                status_code: Response::HTTP_OK
            );
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }
}