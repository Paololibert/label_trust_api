<?php

declare(strict_types=1);

namespace Domains\Roles\Repositories;

use App\Models\Role;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
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
        } catch (ModelNotFoundException $exception) {
            throw new QueryException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while granting access to role.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while granting access to role.", previous: $exception);
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
        } catch (ModelNotFoundException $exception) {
            throw new QueryException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while revoking access from role.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while revoking access from role.", previous: $exception);
        }
    }

}