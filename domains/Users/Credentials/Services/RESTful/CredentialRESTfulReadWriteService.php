<?php

declare(strict_types=1);

namespace Domains\Users\Credentials\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Exceptions\QueryException;
use Domains\Users\Credentials\Services\RESTful\Contracts\CredentialRESTfulReadWriteServiceContract;
use Illuminate\Support\Facades\DB;

/**
 * The ***`CredentialRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Credential" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Credential" resource.
 * It implements the `CredentialRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Users\Credentials\Services\RESTful`***
 */
class CredentialRESTfulReadWriteService extends RestJsonReadWriteService implements CredentialRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the CredentialRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

    /**
     * Authentification
     *
     * @param string $userId                                           The identifier of the user to which role will be granted.
     * @param \Core\Utils\DataTransfertObjects\DTOInterface $auth   The array of role identifiers to grant to a user.
     * 
     * @return \Illuminate\Http\JsonResponse                           The JSON response indicating the status of the roles granting operation.
     * 
     * @throws \Core\Utils\Exceptions\ServiceException                 If there is an issue with the service operation.
     */
    public function authentification(DTOInterface $auth): \Illuminate\Http\JsonResponse
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Call the grantAccess method on the repository to grant access to the role
            $result = $this->queryService->getRepository()->assignRolePrivileges($userId, $roleIds->toArray()['roles']);

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
}