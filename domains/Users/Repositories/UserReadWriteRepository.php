<?php

declare(strict_types=1);

namespace Domains\Users\Repositories;

use App\Models\User;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Enums\Users\TypeOfAccountEnum;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Users\Companies\Repositories\CompanyReadWriteRepository;
use Domains\Users\People\Repositories\PersonReadWriteRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

/**
 * ***`UserReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the User $instance data.
 *
 * @package ***`Domains\Users\Repositories`***
 */
class UserReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * @var PersonReadWriteRepository
     */
    protected $personReadWriteRepository;

    /**
     * @var CompanyReadWriteRepository
     */
    protected $companyReadWriteRepository;

    /**
     * Create a new UserReadWriteRepository instance.
     *
     * @param  \App\Models\User $model
     * @return void
     */
    public function __construct(User $model, PersonReadWriteRepository $personReadWriteRepository, CompanyReadWriteRepository $companyReadWriteRepository)
    {
        parent::__construct($model);

        $this->personReadWriteRepository = $personReadWriteRepository;
        $this->companyReadWriteRepository = $companyReadWriteRepository;
    }

    /**
     * Create a new record.
     *
     * @param  array $data         The data for creating the record.
     * @return Model               The created record.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function create(array $data): Model
    {
        try {

            if ($data['type_of_account'] === TypeOfAccountEnum::PERSONAL->value) {
                $this->model->userable = $this->personReadWriteRepository->create($data['user']);
            } else if ($data['type_of_account'] === TypeOfAccountEnum::MORAL->value) {
                $this->model->userable = $this->companyReadWriteRepository->create($data['user']);
            } else throw new Exception("Unknown type of account", 1);

            if (!$this->model->userable) throw new Exception("Error occur while creating userable", 1);

            $this->model = $this->model->userable->user()->create($data);

            $this->model->refresh();

            if ($this->model && isset($data['role_id'])) {
                $this->model->assignRole($data['role_id']);
            }

            return $this->model->refresh();
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while creating a user record." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Update an existing record.
     *
     * @param  Model|string $id       The ID of the record to update.
     * @param  array        $data     The data for updating the record.
     * @return bool|Model|null        Whether the update was successful or not.
     *
     * @throws ModelNotFoundException If the record with the given ID is not found.
     * @throws \Core\Utils\Exceptions\RepositoryException    If there is an error while updating the record.
     */
    public function update($id, array $data)
    {
        try {
            $this->model = $this->find($id);

            if ($this->model->type_of_account === $data['type_of_account']) {
                $this->model->userable->update($this->model->userable->id, $data['user']);
            } else {
                $userable = $this->model->userable;


                if ($data['type_of_account'] === TypeOfAccountEnum::PERSONAL->value) {
                    $this->model->userable()->associate($this->personReadWriteRepository->create($data['user']));
                    $this->model->save();
                } else if ($data['type_of_account'] === TypeOfAccountEnum::MORAL->value) {
                    $this->model->userable()->associate($this->companyReadWriteRepository->create($data['user']));
                    $this->model->save();
                } else throw new Exception("Unknown type of account", 1);

                if (!$this->model->userable) throw new Exception("Error occur while creating userable", 1);

                $this->model->refresh();

                if ($userable) {
                    $userable->delete();
                }
            }

            $result = $this->model->update($data);
            return $result ? $this->model->refresh() : $result;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while updating the record." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Assign role to user
     *
     * @param  string            $userId                  The id of the user.
     * @param  string|array<int, mixed> $roleIds               The IDs of the user access(s).
     * @return bool                                       Whether the attaching was successful.
     *
     * @throws ModelNotFoundException                     If the user with the given ID is not found.
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while attaching the related user.
     */
    public function assignRolePrivileges(string $userId, array|string $roleIds): bool
    {
        try {

            $user = $this->find($userId);

            return $user->grantPrivileges($roleIds) ? true : false;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while granting access to user record." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Revoke role privilege from user.
     *
     * @param  string            $userId                  The id of the user.
     * @param  string|array<int, mixed> $roleIds                 The IDs of the user access(s) to be revoked.
     * @return bool                                       Whether the revocation was successful.
     *
     * @throws ModelNotFoundException                     If the user with the given ID is not found.
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while detaching the related user.
     */
    public function revokeRolePrivileges(string $userId, array|string $roleIds): bool
    {
        try {
            $user = $this->find($userId);
            return $user->revokePrivileges($roleIds) ? true : false;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while revoking access from user record." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
