<?php

declare(strict_types=1);

namespace Core\Logic\Services\Manager;

use Core\Utils\Exceptions\ServiceException;
use Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface;
use Core\Logic\Services\Contracts\QueryServiceContract;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * `QueryService`
 *
 * This abstract class provides a base implementation of the `QueryServiceContract` interface,
 * which defines methods for querying and retrieving records.
 *
 * @package \Core\Logic\Services\Manager
 */
class QueryService extends AbstractService implements QueryServiceContract
{
    /**
     * Constructor for the **`QueryService`** abstract class.
     *
     * @param \Core\Data\Repositories\Contracts\ReadOnlyRepositoryInterface $readOnlyRepository The read-only repository to be used for querying and retrieving records.
     */
    public function __construct(ReadOnlyRepositoryInterface $readOnlyRepository)
    {
        parent::__construct($readOnlyRepository);
    }

    /**
     * Get all records.
     *
     * @param  array $columns                           The columns to select.
     * @return \Illuminate\Database\Eloquent\Collection The collection of all records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException        If there is an error retrieving the records.
     */
    public function all(array $columns = ['*'])
    {
        try {
            return $this->repository->all($columns);
        } catch (Throwable $exception) {
            throw new \Core\Utils\Exceptions\ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Paginate the records.
     *
     *
     * @param  int        $perPage               The number of results to display per page.
     * @param  string     $pageName              The query string variable used to store the current page.
     * @param  int|null   $page                  The current page number.
     * @return mixed                             The collection of paginated records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error paginating the records.
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], string $orderBy = "created_at", string $order = "desc", string $pageName = 'page', ?int $page = null)
    {
        try {
            return $this->repository->getModel()->orderBy($orderBy, 'desc')->paginate(perPage: $perPage, columns: $columns, pageName: $pageName, page: $page);
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Find a record by its ID.
     *
     * @param  Model|string $id                  The ID of the record.
     * @param  array        $columns             The columns to select.
     * @return mixed                             The found record, or null if not found.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error finding the record.
     */
    public function findById($id, array $columns = ['*'])
    {
        try {
            return $this->repository->find($id, $columns);
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Retrieve data based on the provided query criteria.
     *
     * @param  array $criteria                          The criteria for filtering the records.
     * @param  array $columns                           The columns to select.
     * @return \Illuminate\Database\Eloquent\Collection The collection of filtered records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException        If there is an error retrieving the filtered records.
     */
    public function where(array $criteria, array $columns = ['*'])
    {
        try {
            return $this->repository->where($criteria, $columns);
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Get the total count of records.
     *
     * @param  array $criteria                   The criteria for filtering the records.
     * @return int                               The total count of records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error counting the records.
     */
    public function count(array $criteria): int
    {
        try {
            return $this->repository->count($criteria);
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Perform a custom query or action.
     *
     * @param  string           $query           The query or action to perform.
     * @param  array            $params          Additional parameters for the query.
     * @return mixed                             The result of the query or action.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error executing the custom query or action.
     */
    public function executeQuery(string $query, array $params = [])
    {
        try {
            return $this->repository->where($params);
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }


    /**
     * Get all soft-deleted records.
     *
     * @param  array $columns                       The columns to select.
     * @return mixed                                The collection of soft-deleted records.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while retrieving the soft-deleted records.
     * @throws \Core\Utils\Exceptions\QueryException      If there is an error while retrieving the soft-deleted records.
     */
    public function trash(array $columns = ['*'])
    {
        try {
            return $this->repository->trash($columns);
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Get all soft deleted records.
     *
     * @param  Model|string $id                  The ID of the record.
     * @param  array        $columns             The columns to select.
     * @return Model|null                        The collection of soft deleted records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error retrieving the soft deleted records.
     */
    public function getTrash($id, array $columns = ['*']): ?Model
    {
        try {
            return $this->repository->getModel()->onlyTrash($id)->select($columns)->get();
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

}
