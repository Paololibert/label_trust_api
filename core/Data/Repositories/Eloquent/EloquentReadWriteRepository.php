<?php

declare(strict_types=1);

namespace Core\Data\Repositories\Eloquent;

use Carbon\Carbon;
use Core\Utils\Exceptions\QueryException as CoreQueryException;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Core\Data\Repositories\Contracts\ReadWriteRepositoryInterface;
use Core\Utils\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * The ***`EloquentReadWriteRepository`*** abstract class.
 *
 * This abstract class serves as a base class for read-write repositories that interact with an Eloquent model.
 * It extends the `BaseRepository` class and implements the `ReadWriteRepositoryInterface`.
 *
 * @package ***`Core\Data\Repositories\Eloquent`***
 */
class EloquentReadWriteRepository extends EloquentReadOnlyRepository implements ReadWriteRepositoryInterface
{

    /**
     * EloquentReadWriteRepository constructor.
     *
     * @param \Illuminate\Database\Eloquent\Model $model The Eloquent model associated with the repository.
     */
    public function __construct(Model $model)
    {
        parent::__construct($model);
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
            return $this->model->create($data)->fresh();
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }

    /**
     * Create a new record.
     *
     * @param  array $identifiers         The data for creating the record.
     * @param  array $data                The data for creating the record.
     * @return Model                      The created record.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function firstOrCreate(array $identifiers, array $data): Model
    {
        try {
            return $this->model->firstOrCreate($identifiers, $data)->fresh();
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
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
            $record = parent::find($id);
            $result = $record->update($data);
            return $result ? $record->fresh() : $result;
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException(message: $exception->getMessage(), code: $exception->getCode());
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while updating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while updating the record.", previous: $exception);
        }
    }

    /**
     * Update an existing record.
     *
     * @param  array        $data                            The data for updating the record.
     * return bool|array<int, bool|Model|null>|null         Whether the update was successful or not.
     *
     * @throws ModelNotFoundException                        If the record with the given ID is not found.
     * @throws \Core\Utils\Exceptions\RepositoryException    If there is an error while updating the record.
     */
    public function updateMultiple(array $data, array $filters = [], string $checker = "id")
    {
        try {

            $query = $this->model;

            if ($filters) {
                foreach ($filters as $filterName => $filter) {
                    foreach ($filter as $condition) {
                        switch ($filterName) {
                            case 'whereIn':
                                $query = $query->{$filterName}($condition[0], $condition[1]);
                                break;

                            default:
                                $query = $query->{$filterName}($condition[0], $condition[1], $condition[2]);
                                break;
                        }
                    }
                }
            }
                
            foreach ($data as $key => $item) {
                unset($item['id']);
                $affectedRows[] =$query->update($item);
            }

            return $affectedRows; ///$result ? $record->fresh() : $result;
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException(message: $exception->getMessage(), code: $exception->getCode());
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while updating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while updating the record.", previous: $exception);
        }
    }

    /**
     * Attach a related model to the record.
     *
     * @param  array<int, mixed> $ids       The ID or IDs of the record(s).
     * @param  string            $relation  The name of the relation.
     * @param  mixed             $relatedId The ID of the related model to attach.
     * @return bool                         Whether the attachment was successful.
     *
     * @throws ModelNotFoundException       If the record with the given ID or the related model is not found.
     * @throws \Core\Utils\Exceptions\RepositoryException          If there is an error while attaching the related model.
     */
    public function attach(array $ids, string $relation, $relatedId): bool
    {
        try {

            $records = $this->model->whereIn('id', $ids)->get();
            $relatedModel = $this->model->{$relation}()->getRelated();

            if (!$relatedModel->where('id', $relatedId)->exists())
                throw new ModelNotFoundException("The related model with ID '$relatedId' does not found.");

            $relationMethod = $this->model->{$relation}();
            $relationMethod->attach($relatedId);

            foreach ($records as $record) {
                $relationMethod->updateExistingPivot($record->id, []);
            }

            return true;
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while attaching the related model.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while attaching the related model.", previous: $exception);
        }
    }

    /**
     * Detach a related model from the record.
     *
     * @param  array<int, mixed> $ids       The ID or IDs of the record(s).
     * @param  string            $relation  The name of the relation.
     * @param  mixed             $relatedId The ID of the related model to detach.
     * @return bool                         Whether the detachment was successful.
     *
     * @throws ModelNotFoundException       If the record with the given ID or the related model is not found.
     * @throws \Core\Utils\Exceptions\RepositoryException          If there is an error while detaching the related model.
     */
    public function detach(array $ids, string $relation, $relatedId): bool
    {
        try {

            $records = $this->model->whereIn('id', $ids)->get();
            $relatedModel = $this->model->{$relation}()->getRelated();

            if (!$relatedModel->where('id', $relatedId)->exists())
                throw new ModelNotFoundException("The related model with ID '$relatedId' does not found.");

            $relationMethod = $this->model->{$relation}();
            $relationMethod->detach($relatedId);

            foreach ($records as $record) {
                $relationMethod->updateExistingPivot($record->id, []);
            }

            return true;
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while detaching the related model.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while detaching the related model.", previous: $exception);
        }
    }

    /**
     * Associate a related model with the record.
     *
     * @param  Model|string $id        The ID of the record.
     * @param  string       $relation  The name of the relation.
     * @param  mixed        $relatedId The ID of the related model to associate.
     * @return bool|Model              Whether the association was successful.
     *
     * @throws ModelNotFoundException  If the record with the given ID or the related model is not found.
     * @throws \Core\Utils\Exceptions\RepositoryException     If there is an error while associating the related model.
     */
    public function associate($id, string $relation, $relatedId)
    {
        try {
            $record = parent::find($id);
            $relatedModel = $this->model->{$relation}()->getRelated();

            if (!$relatedModel->where('id', $relatedId)->exists())
                throw new ModelNotFoundException("Related model with ID {$relatedId} not found.");

            $record->{$relation}()->associate($relatedId);
            $record->save();

            return $record;
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while associating the related model.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while associating the related model.", previous: $exception);
        }
    }

    /**
     * Soft delete one or more records.
     *
     * @param  string|array $ids      The ID or IDs of the record(s) to soft delete.
     * @return bool                   Whether the soft delete was successful.
     *
     * @throws ModelNotFoundException If any of the records with the given IDs are not found.
     * @throws \Core\Utils\Exceptions\RepositoryException    If there is an error while performing the soft delete.
     */
    public function softDelete($ids, array $filters = []): bool
    {
        try {
            $result = true;

            if (is_string($ids)) {

                // Soft delete a single record
                $query = $this->model->where("id", (string) $ids);

                if ($filters) {
                    foreach ($filters as $filterName => $filter) {
                        foreach ($filter as $condition) {
                            switch ($filterName) {
                                case 'whereIn':
                                    $query = $query->{$filterName}($condition[0], $condition[1]);
                                    break;

                                default:
                                    $query = $query->{$filterName}($condition[0], $condition[1], $condition[2]);
                                    break;
                            }
                        }
                    }
                }

                $uniqueColumns = $this->getUniqueColumns();

                if ($uniqueColumns) {

                    // Update multiple records before updated
                    $updatedValues = [];

                    foreach ($uniqueColumns as $column) {
                        if ($this->model->hasCast($column, ["string"])) {
                            // Get the current date and time
                            $currentDateTime = Carbon::now()->format('Y-m-d_H:i:s');
                            // Combine the existing value with the current date and hour value
                            $updatedValues[$column] = DB::raw("CONCAT({$column}, '_{$currentDateTime}')");
                        }
                    }

                    $query->update($updatedValues);
                }

                $result = $query->delete();
            } else {

                $result = [];
                $query = $this->model;

                if ($filters) {
                    foreach ($filters as $filterName => $filter) {
                        foreach ($filter as $condition) {
                            switch ($filterName) {
                                case 'whereIn':
                                    $query = $query->{$filterName}($condition[0], $condition[1]);
                                    break;

                                default:
                                    $query = $query->{$filterName}($condition[0], $condition[1], $condition[2]);
                                    break;
                            }
                        }
                    }
                }

                if ($ids) {
                    $query = $query->whereIn("id", $ids);
                }

                $ids = $query->select("id")->pluck("id");

                if (count($ids)) {

                    $uniqueColumns = $this->getUniqueColumns();

                    if ($uniqueColumns) {

                        // Update multiple records before updated
                        $updatedValues = [];

                        foreach ($uniqueColumns as $column) {
                            // Get the current date and time
                            $currentDateTime = Carbon::now()->format('Y-m-d_H:i:s');
                            // Combine the existing value with the current date and hour value
                            $updatedValues[$column] = DB::raw("CONCAT({$column}, '_{$currentDateTime}')");
                        }

                        $query->update($updatedValues);
                    }

                    // Soft delete multiple records
                    $result = $query->delete();

                    return $result === count($ids);
                }
                
                return true;
            }

            return $result ? true : false;
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while performing the soft delete of record(s).", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while performing the soft delete of record(s).", previous: $exception);
        }
    }

    /**
     * Permanently delete one or more soft deleted records.
     *
     * @param  string|array $ids      The ID or IDs of the record(s) to permanently delete.
     * @return bool                   Whether the permanent deletion was successful.
     *
     * @throws ModelNotFoundException If any of the soft deleted records with the given IDs are not found.
     * @throws \Core\Utils\Exceptions\RepositoryException    If there is an error while performing the permanent deletion.
     */
    public function permanentlyDelete($ids): bool
    {
        try {

            $result = true;

            if (is_string($ids)) {
                $result = $this->find($ids)->forceDelete();
            } else {
                $result = [];
                foreach ($this->model->whereIn('id', $ids)->get() as $record) {
                    $result[] = $record->forceDelete();
                }

                return count($result) === count($ids);
            }

            return $result;
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while performing the permanent deletion.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while performing the permanent deletion.", previous: $exception);
        }
    }

    /**
     * Restore one or more soft deleted records.
     *
     * @param  string|array $ids             The ID or IDs of the soft deleted record(s) to restore.
     * @return bool                   Whether the restoration of all soft deleted records was successful.
     *
     * @throws ModelNotFoundException If any of the soft deleted records with the given IDs are not found.
     * @throws \Core\Utils\Exceptions\RepositoryException    If there is an error while restoring the soft deleted records.
     */
    public function restore($ids): bool
    {
        try {

            $result = true;

            if (is_string($ids)) {
                $result = $this->onlyTrashed()->findOrfail($ids)->restore();
            } else {
                $result = [];
                foreach ($this->onlyTrashed()->whereIn('id', $ids)->get() as $record) {
                    $result[] = $record->restore();
                }

                return count($result) === count($ids);
            }

            return $result;
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while restoring the soft delete record(s).", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while restoring the soft delete record(s).", previous: $exception);
        }
    }

    /**
     * Restore all soft deleted records.
     *
     * @return bool                Whether the restoration of all soft deleted records was successful.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while restoring all soft deleted records.
     */
    public function restoreAll(): bool
    {
        try {
            return (bool) $this->model->onlyTrashed()->restore();
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while restoring all soft deleted records.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while restoring all soft deleted records.", previous: $exception);
        }
    }

    /**
     * Empty the trash by permanently deleting all soft deleted records.
     *
     * @return bool                Whether the emptying of trash was successful.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while emptying the trash.
     */
    public function emptyTrash(): bool
    {
        try {
            return (bool) $this->model->onlyTrashed()->forceDelete();
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while emptying the trash.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while emptying the trash.", previous: $exception);
        }
    }

    /**
     * Permanently delete all records.
     *
     * @return bool                Whether the permanent deletion of all records was successful.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while performing the permanent deletion.
     */
    public function permanentlyDeleteAll(): bool
    {
        try {
            return (bool) $this->model->withTrashed()->forceDelete();
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while performing the permanent deletion of all records.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while performing the permanent deletion of all records.", previous: $exception);
        }
    }
}
