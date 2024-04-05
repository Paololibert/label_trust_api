<?php

declare(strict_types=1);

namespace Domains\Roles\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Roles\Services\RESTful\Contracts\RoleRESTfulReadWriteServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * The ***`RoleRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Role" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Role" resource.
 * It implements the `RoleRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Roles\Services\RESTful`***
 */
class RoleRESTfulReadWriteService extends RestJsonReadWriteService implements RoleRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the RoleRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

    /**
     * Create a new record.
     *
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface $data The data for creating the record.
     * @return \Illuminate\Http\JsonResponse                 The JSON response indicating whether the create was successful or not.
     *
     * @throws \Core\Utils\Exceptions\ServiceException             If there is an error while creating the record.
     */
    public function create(DTOInterface $data): JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            $role = $this->readWriteService->create($data);
            
            $this->grantAccess($role->id, $data);
            
            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Role created successfully',
                data: $role->fresh(),
                status_code: Response::HTTP_CREATED
            );
        } catch (CoreException $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to created role : ' . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Grant access to a role.
     *
     * @param string $roleId                                           The identifier of the role to which access will be granted.
     * @param \Core\Utils\DataTransfertObjects\DTOInterface $accessIds The array of access identifiers to grant to the role.
     * 
     * @return \Illuminate\Http\JsonResponse                           The JSON response indicating the status of the access grant operation.
     * 
     * @throws \Core\Utils\Exceptions\ServiceException                 If there is an issue with the service operation.
     */
    public function grantAccess(string $roleId, DTOInterface $accessIds): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Call the grantAccess method on the repository to grant access to the role
            $result = $this->queryService->getRepository()->grantAccess($roleId, $accessIds->toArray()['permissions']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to grant access to the role. Access not granted.", 1);
            }
        
            // Commit the transaction since the access was granted successfully
            DB::commit();

            // Return a success response
            return JsonResponseTrait::success(
                message: 'Access granted to role successfully',
                data: $result,
                status_code: Response::HTTP_CREATED
            );

        } catch (CoreException $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to grant access to role : ' . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Revoke access from a role.
     *
     * @param string $roleId                                           The identifier of the role from which access will be revoked.
     * @param \Core\Utils\DataTransfertObjects\DTOInterface $accessIds The array of access identifiers to revoke from the role.
     * 
     * @return \Illuminate\Http\JsonResponse                           The JSON response indicating the status of the access revocation operation.
     * 
     * @throws \Core\Utils\Exceptions\ServiceException                 If there is an issue with the service operation.
     */
    public function revokeAccess(string $roleId, DTOInterface $accessIds): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Call the revokeAccess method on the repository to grant access to the role
            $result = $this->queryService->getRepository()->revokeAccess($roleId, $accessIds->toArray()['permissions']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to grant access to the role. Access not granted.", 1);
            }

            // Commit the transaction since the access was revoked successfully
            DB::commit();

            return JsonResponseTrait::success(
                message: 'Access revoked from role successfully',
                data: $result,
                status_code: Response::HTTP_CREATED
            );

        } catch (CoreException $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to revoke access from role : ' . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

}