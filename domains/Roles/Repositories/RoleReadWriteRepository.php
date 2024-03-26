<?php

declare(strict_types=1);

namespace Domains\Roles\Repositories;

use App\Models\Role;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

/**
 * ***`RoleReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Role $instance data.
 *
 * @package ***`Domains\Roles\Repositories`***
 */
class RoleReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new RoleReadWriteRepository instance.
     *
     * @param  \App\Models\Role $model
     * @return void
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * Grant access to role
     *
     * @param  string            $roleId                  The id of the role.
     * @param  array<int, mixed> $accessIds               The IDs of the role access(s).
     * @return bool                                       Whether the attaching was successful.
     *
     * @throws ModelNotFoundException                     If the role with the given ID is not found.
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while attaching the related role.
     */
    public function grantAccess(string $roleId, array $accessIds): bool
    {
        try {

            $role = $this->find($roleId);

            return $role->grantAccess($accessIds) ? true : false;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while granting access to role." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Revoke access from role.
     *
     * @param  string            $roleId                  The id of the role.
     * @param  array<int, mixed> $accessIds               The IDs of the role access(s) to be revoked.
     * @return bool                                       Whether the revocation was successful.
     *
     * @throws ModelNotFoundException                     If the role with the given ID is not found.
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while detaching the related role.
     */
    public function revokeAccess(string $roleId, array $accessIds): bool
    {
        try {
            $role = $this->find($roleId);

            return $role->revokeAccess($accessIds) ? true : false;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while revoking access from role." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

}