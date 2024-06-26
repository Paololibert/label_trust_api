<?php

declare(strict_types=1);

namespace Core\Data\Repositories\Eloquent;

use Core\Utils\Exceptions\QueryException as CoreQueryException;
use Core\Utils\Exceptions\RepositoryException;
use Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface;
use Core\Utils\Exceptions\InvalidArgumentException;
use Core\Utils\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Throwable;

/**
 * The ***`EloquentReadOnlyRepository`*** abstract class.
 *
 * This abstract class serves as a base class for read-only repositories that interact with an Eloquent model.
 * It implements the `ReadOnlyRepositoryInterface` and provides common read operations.
 *
 * @package ***`Core\Data\Repositories\Eloquent`***
 */
class EloquentReadOnlyRepository extends BaseRepository implements ReadOnlyRepositoryInterface
{

    /**
     * `EloquentReadOnlyRepository` constructor.
     *
     * Creates a new instance of the `EloquentReadOnlyRepository` class, associating it with the provided Eloquent model.
     * This constructor is called when you create a new instance of the repository, allowing you to specify the model
     * that the repository will interact with.
     *
     * @param \Illuminate\Database\Eloquent\Model $model The Eloquent model associated with the repository.
     */
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all records.
     *
     * @param  array $columns                           The columns to select.
     * @return \Illuminate\Database\Eloquent\Collection The collection of all records.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException     If there is an error while retrieving the records.
     */
    public function all(array $columns = ['*']): Collection
    {
        try {

            return $this->model->select($columns)->get();
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while retrieving records.", previous: $exception);
        }
    }

    /**
     * Find a record by its ID.
     *
     * @param  Model|string $id                                     The ID of the record.
     * @param  array        $columns                                The columns to select.
     * @return Model|null                                           The found record, or null if not found.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the record with the given ID is not found.
     * @throws \Core\Utils\Exceptions\QueryException                      If there is an error while retrieving the record.
     * @throws \Core\Utils\Exceptions\RepositoryException                 If there is an error while retrieving the record.
     */
    public function find($id, array $columns = ['*']): ?Model
    {
        try {
            return $this->model->select($columns)->findOrFail($id)->fresh();
        } catch (ModelNotFoundException $exception) {
            // Customize the message for ModelNotFoundException
            throw new NotFoundException(message: "Record not found.", previous: $exception);
        } catch (QueryException $exception) {
            // Catch QueryException and handle the case of invalid UUID
            if ($exception->getCode() === '22P02') {
                // Handle the case of invalid UUID
                // For example, you can log the error or notify the user
                // Then, throw a custom exception
                throw new InvalidArgumentException(message: "Invalid UUID provided.", status_code: Response::HTTP_BAD_REQUEST, error: $exception->errorInfo, previous: $exception);
            }
            throw new CoreQueryException(message: "Error while retrieving the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while retrieving records.", previous: $exception);
        }
    }

    /**
     * Get the first record that matches the given conditions.
     *
     * @param  array<int, array> $conditions        The conditions for filtering the records.
     * @param array $columns                        The columns to select.
     * @return Model|null                           The first matching record, or null if not found.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while retrieving the record.
     * @throws \Core\Utils\Exceptions\QueryException      If there is an error while retrieving the record.
     */
    public function first(array $conditions, array $columns = ['*']): ?Model
    {
        try {
            return $this->model->select($columns)->where($conditions)->first()?->fresh();
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while retrieving the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while retrieving the record.", previous: $exception);
        }
    }

    /**
     * Check if a record exists based on the given conditions.
     *
     * @param  array<int, array> $conditions        The conditions for filtering the records.
     * @return bool                                 Whether a record exists or not.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while checking for record existence.
     * @throws \Core\Utils\Exceptions\QueryException      If there is an error while checking for record existence.
     */
    public function exists(array $conditions): bool
    {
        try {
            return $this->model->where($conditions)->exists();
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while checking for record existence.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while checking for record existence.", previous: $exception);
        }
    }

    /**
     * Check if the specified relationship exists for the given IDs.
     *
     * @param Relation $relation
     * @param array $ids
     *
     * @return bool
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while checking for record existence.
     * @throws \Core\Utils\Exceptions\QueryException      If there is an error while checking for record existence.
     */
    public function relationExists(Relation $relation, array $ids, bool $isPivot = true): bool
    {
        try {
            if ($isPivot) {
                return $relation->wherePivotIn('id', $ids)->exists();
            } else {
                return $relation->whereIn('id', $ids)->exists();
            }
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while checking for record existence.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while checking for record existence.", previous: $exception);
        }
    }

    /**
     * Get the total count of records.
     *
     * @param  array<int, array> $conditions        The conditions for filtering the records.
     * @return int                                  The total count of records.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while counting the records.
     * @throws \Core\Utils\Exceptions\QueryException      If there is an error while counting the records.
     */
    public function count(array $conditions): int
    {
        try {
            return $this->model->where($conditions)->count();
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while counting the records.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while counting the records.", previous: $exception);
        }
    }

    /**
     * Get records based on the given conditions.
     *
     * @param  array<int, array> $conditions            The conditions for filtering the records.
     * @param array              $columns               The columns to select.
     * @return \Illuminate\Database\Eloquent\Collection The collection of filtered records.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException     If there is an error while retrieving the records.
     * @throws \Core\Utils\Exceptions\QueryException          If there is an error while retrieving the records.
     */
    public function where(array $conditions, array $columns = ['*']): Collection
    {
        try {
            $query = $this->model;

            if ($conditions) {
                foreach ($conditions as $filterName => $filter) {
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
            return $query->get($columns);
            // return parent::filter($conditions)->select($columns)->get();
            return $this->model->select($columns)->where($conditions)->get();
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while retrieving the records.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while retrieving the records.", previous: $exception);
        }
    }

    /**
     * Get all soft-deleted records.
     *
     * @param  array $columns      The columns to select.
     * @return mixed               The collection of soft-deleted records.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while retrieving the soft-deleted records.
     * @throws \Core\Utils\Exceptions\QueryException      If there is an error while retrieving the soft-deleted records.
     */
    public function trash(array $columns = ['*'])
    {
        try {
            return $this->model->select($columns)->onlyTrashed()->paginate(5);
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while retrieving the soft-deleted records.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while retrieving the soft-deleted records.", previous: $exception);
        }
    }
}
