<?php

declare(strict_types=1);

namespace Domains\Users\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Users\Services\RESTful\Contracts\UserRESTfulReadWriteServiceContract;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * The ***`UserRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "User" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "User" resource.
 * It implements the `UserRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Users\Services\RESTful`***
 */
class UserRESTfulReadWriteService extends RestJsonReadWriteService implements UserRESTfulReadWriteServiceContract
{

    /**
     * Constructor for the UserRESTfulReadWriteService class.
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

            $user = $this->readWriteService->create($data);

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'User created successfully',
                data: $user,
                status_code: Response::HTTP_CREATED
            );
        } catch (Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Update an existing record.
     *
     * @param  Model|string                                     $id     The ID of the record to update.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface    $data   The data for updating the record.
     * @return \Illuminate\Http\JsonResponse                            The JSON response indicating whether the update was successful or not.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                  If there is an error while updating the record.
     */
    public function update($id, DTOInterface $data): JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {

            $user = $this->readWriteService->getRepository()->update($id, $data->toArray());

            // Commit the transaction
            DB::commit();

            return JsonResponseTrait::success(
                message: 'User updated successfully',
                data: $user,
                status_code: Response::HTTP_CREATED
            );
        } catch (Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Assign role privileges to a user.
     *
     * @param string $userId                                           The identifier of the user to which role will be granted.
     * @param \Core\Utils\DataTransfertObjects\DTOInterface $roleIds   The array of role identifiers to grant to a user.
     * 
     * @return \Illuminate\Http\JsonResponse                           The JSON response indicating the status of the roles granting operation.
     * 
     * @throws \Core\Utils\Exceptions\ServiceException                 If there is an issue with the service operation.
     */
    public function assignRolePrivileges(string $userId, DTOInterface $roleIds): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Call the grantAccess method on the repository to grant access to the role
            $result = $this->readWriteService->getRepository()->assignRolePrivileges($userId, $roleIds->toArray()['roles']);

            // If the result is false, throw a custom exception
            if (!$result) {
                throw new QueryException("Failed to grant role privilege to the user. Role not granted.", 1);
            }
        
            // Commit the transaction since the access was granted successfully
            DB::commit();

            // Return a success response
            return JsonResponseTrait::success(
                message: 'Role privilege granted successfully to the user.',
                data: $result,
                status_code: Response::HTTP_CREATED
            );

        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            // Throw a ServiceException with an error message and the caught exception
            throw new ServiceException(message: 'Failed to grant role privile to the user : ' . $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Revoke role privileges from a user.
     *
     * @param string $userId                                           The identifier of the user from which role will be revoked.
     * @param \Core\Utils\DataTransfertObjects\DTOInterface $roleIds   The array of roles identifiers to revoke from a user.
     * 
     * @return \Illuminate\Http\JsonResponse                           The JSON response indicating the status of the user granted roles revocation operation.
     * 
     * @throws \Core\Utils\Exceptions\ServiceException                 If there is an issue with the service operation.
     */
    public function revokeRolePrivileges(string $userId, DTOInterface $roleIds): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Call the revokeAccess method on the repository to grant access to the role
            $result = $this->readWriteService->getRepository()->revokeRolePrivileges($userId, $roleIds->toArray()['roles']);

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

        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            
            throw new ServiceException(message: 'Failed to revoke access from role : ' . $exception->getMessage(), previous: $exception);
        }
    }
}