<?php

declare(strict_types=1);

namespace Core\Logic\Services\Manager;

use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Exceptions\ServiceException;
use Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface;
use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Class `ReadWriteService`
 *
 * The `ReadWriteService` class provides a concrete implementation of the `ReadWriteServiceContract`.
 * It extends the `QueryService` class and adds write operations to manipulate data using the associated `ReadWriteRepositoryInterface`.
 * This class is responsible for creating, updating, soft deleting, restoring, and permanently deleting records.
 *
 * @package \Core\Logic\Services\Manager
 */
class ReadWriteService extends QueryService implements ReadWriteServiceContract
{
    /**
     * Constructor for the ReadWriteService abstract class.
     *
     * @param ReadWriteRepositoryInterface $readWriteRepository The read-write repository to be used for querying, retrieving and writing records.
     */
    public function __construct(ReadWriteRepositoryInterface $readWriteRepository)
    {
        parent::__construct($readWriteRepository);
    }

    /**
     * Create a new record.
     *
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface $data The data for creating the record.
     * @return Model|null                                    The created record.
     *
     * @throws \Core\Utils\Exceptions\ServiceException             If there is an error while creating the record.
     */
    public function create(DTOInterface $data)
    {
        try {
            return $this->repository->create($data->toArray())->fresh();
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Update an existing record.
     *
     * @param  Model|string           $id                    The ID of the record to update.
     * @param  \Core\Utils\DataTransfertObjects\DTOInterface $data The data for updating the record.
     * @return bool|Model|null                               Whether the update was successful or not.
     *
     * @throws \Core\Utils\Exceptions\ServiceException             If there is an error while updating the record.
     */
    public function update($id, DTOInterface $data)
    {
        try {
            return $this->repository->update($id, $data->toArray());
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Soft delete one or more records.
     *
     * @param  string|array $ids                The ID or IDs of the record(s) to soft delete.
     * @return bool                             Whether the soft delete was successful.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error while performing the soft delete.
     */
    public function softDelete($ids)
    {
        try {
            return $this->repository->softDelete($ids);
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Permanently delete one or more soft deleted records.
     *
     * @param  string|array $ids                The ID or IDs of the record(s) to permanently delete.
     * @return bool                             Whether the permanent deletion was successful.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error while performing the permanent deletion.
     */
    public function permanentlyDelete($ids): bool
    {
        try {
            return $this->repository->permanentlyDelete($ids);
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Restore one or more soft deleted records.
     *
     * @param  string|array $ids                The ID or IDs of the soft deleted record(s) to restore.
     * @return bool                             Whether the restoration of all soft deleted records was successful.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error while restoring the soft deleted records.
     */
    public function restore($ids): bool
    {
        try {
            return $this->repository->restore($ids);
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Restore all soft deleted records.
     *
     * @return bool                             Whether the restoration of all soft deleted records was successful.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error while restoring all soft deleted records.
     */
    public function restoreAll(): bool
    {
        try {
            return $this->repository->restoreAll();
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Empty the trash by permanently deleting all soft deleted records.
     *
     * @return bool                             Whether the emptying of trash was successful.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error while emptying the trash.
     */
    public function emptyTrash(): bool
    {
        try {
            return $this->repository->emptyTrash();
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Permanently delete all records.
     *
     * @return bool                             Whether the permanent deletion of all records was successful.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error while performing the permanent deletion.
     */
    public function permanentlyDeleteAll(): bool
    {
        try {
            return $this->repository->permanentlyDeleteAll();
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }
}
