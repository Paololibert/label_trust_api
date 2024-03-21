<?php

declare(strict_types=1);

namespace Core\Data\Repositories\Contracts;

use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * ***`ReadOnlyRepositoryInterface`***
 *
 * The `ReadOnlyRepositoryInterface` defines the contract for a read-only repository.
 * It specifies the methods that can be implemented to retrieve data without modifying it.
 *
 * @package ***`Core\Data\Repositories\Contracts`***
 */
interface ReadOnlyRepositoryInterface
{
    /**
     * Set the model associated with the repository.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $model The model instance.
     * @return void
     */
    public function setModel(?\Illuminate\Database\Eloquent\Model $model): void;

    /**
     * Get the model associated with the repository.
     *
     * @return \Illuminate\Database\Eloquent\Model|null The model instance.
     */
    public function getModel(): ?\Illuminate\Database\Eloquent\Model;

    /**
     * Get the name of the model associated with the repository.
     *
     * @return string The model name.
     */
    public function getModelName(): ?string;

    /**
     * Get all records.
     *
     * @param  array $columns                            The columns to select.
     * @return \Illuminate\Database\Eloquent\Collection  The collection of all records.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException      If there is an error while retrieving the records.
     */
    public function all(array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;

    /**
     * Find a record by its ID.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string $id                                     The ID of the record.
     * @param  array        $columns                                 The columns to select.
     * @return \Illuminate\Database\Eloquent\Model|null                                           The found record, or null if not found.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  If the record with the given ID is not found.
     * @throws \Core\Utils\Exceptions\QueryException                       If there is an error while retrieving the record.
     * @throws \Core\Utils\Exceptions\RepositoryException                  If there is an error while retrieving the record.
     */
    public function find($id, array $columns = ['*']): ?\Illuminate\Database\Eloquent\Model;

    /**
     * Get the first record that matches the given conditions.
     *
     * @param  array<int, array> $conditions                     The conditions for filtering the records.
     * @param  array             $columns                        The columns to select.
     * @return @return \Illuminate\Database\Eloquent\Model|null  The first matching record, or null if not found.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException              If there is an error while retrieving the record.
     * @throws \Core\Utils\Exceptions\QueryException                   If there is an error while retrieving the record.
     */
    public function first(array $conditions, array $columns = ['*']): ?\Illuminate\Database\Eloquent\Model;

    /**
     * Check if a record exists based on the given conditions.
     *
     * @param  array<int, array> $conditions         The conditions for filtering the records.
     * @return bool                                  Whether a record exists or not.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException  If there is an error while checking for record existence.
     * @throws \Core\Utils\Exceptions\QueryException       If there is an error while checking for record existence.
     */
    public function exists(array $conditions): bool;
    
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
    public function relationExists(Relation $relation, array $ids, bool $isPivot = true): bool;

    /**
     * Get the total count of records.
     *
     * @param  array<int, array> $conditions         The conditions for filtering the records.
     * @return int                                   The total count of records.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException  If there is an error while counting the records.
     * @throws \Core\Utils\Exceptions\QueryException       If there is an error while counting the records.
     */
    public function count(array $conditions): int;

    /**
     * Get records based on the given conditions.
     *
     * @param  array<int, array> $conditions             The conditions for filtering the records.
     * @param  array             $columns                The columns to select.
     * @return \Illuminate\Database\Eloquent\Collection  The collection of filtered records.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException      If there is an error while retrieving the records.
     * @throws \Core\Utils\Exceptions\QueryException           If there is an error while retrieving the records.
     */
    public function where(array $conditions, array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get all soft-deleted records.
     *
     * @param  array $columns                        The columns to select.
     * @return mixed                                 The collection of soft-deleted records.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException  If there is an error while retrieving the soft-deleted records.
     * @throws \Core\Utils\Exceptions\QueryException       If there is an error while retrieving the soft-deleted records.
     */
    public function trash(array $columns = ['*']);
}
