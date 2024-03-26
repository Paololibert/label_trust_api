<?php

declare(strict_types=1);

namespace Core\Logic\Services\RestJson;

use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;
use Core\Utils\Exceptions\Contract\CoreException;
use Illuminate\Database\Eloquent\Model;


/**
 * Class `RestJsonQueryService`
 *
 * The `RestJsonQueryService` class is an abstract class that provides a concrete implementation of the `RestJsonQueryServiceContract`.
 * It extends the `QueryService` class and adds methods for retrieving records in a `RESTful` JSON format.
 * This class is responsible for retrieving all records, `paginating` records, `finding` records by ID, `filtering` records based on `criteria`, `counting` records, and `retrieving` soft deleted records.
 *
 * @package \Core\Logic\Services\RestJson
 */
abstract class RestJsonQueryService implements RestJsonQueryServiceContract
{

    /**
     * The query service instance.
     *
     * @var \Core\Logic\Services\Contracts\QueryServiceContract|null
     */
    protected QueryServiceContract $queryService;


    public function __construct(QueryServiceContract $queryService)
    {
        $this->queryService = $queryService;
    }

    /**
     * Set the read-only service associated with the service.
     *
     * @param  \Core\Logic\Services\Contracts\QueryServiceContract $service The read-only service instance.
     * @return void
     */
    public function setReadOnlyService(QueryServiceContract $service): void
    {
        $this->queryService = $service;
    }

    /**
     * Get the read-only service associated with the service.
     *
     * @return \Core\Logic\Services\Contracts\QueryServiceContract The read-only service instance.
     */
    public function getReadOnlyService(): \Core\Logic\Services\Contracts\QueryServiceContract
    {
        return $this->queryService;
    }

    /**
     * Get all records.
     *
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of all records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error retrieving the records.
     */
    public function all(array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(message: "", data: $this->queryService->all($columns));
        } catch (CoreException $exception) {
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Paginate the records.
     *
     *
     * @param  int        $perPage               The number of results to display per page.
     * @param  string     $pageName              The query string variable used to store the current page.
     * @param  int|null   $page                  The current page number.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of paginated records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error paginating the records.
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], string $orderBy = "created_at", string $order = "desc", string $pageName = 'page', ?int $page = null): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->paginate(perPage: $perPage, columns: $columns, orderBy: $orderBy, order: $order, pageName: $pageName, page: $page));
        } catch (CoreException $exception) {
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Find a record by its ID.
     *
     * @param  Model|string $id                  The ID of the record.
     * @param  array        $columns             The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the found record, or null if not found.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error finding the record.
     */
    public function findById($id, array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->findById($id, $columns));
        } catch (CoreException $exception) {
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), previous: $exception);
        }
    }

    /**
     * Retrieve data based on the provided query criteria.
     *
     * @param  array $criteria                   The criteria for filtering the records.
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of filtered records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error retrieving the filtered records.
     */
    public function where(array $criteria, array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->where($criteria, $columns));
        } catch (CoreException $exception) {
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Get the total count of records.
     *
     * @param  array $criteria                   The criteria for filtering the records.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the total count of records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error counting the records.
     */
    public function count(array $criteria): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->count($criteria));
        } catch (CoreException $exception) {
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Get all soft deleted records.
     *
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of soft deleted records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error retrieving the soft deleted records.
     */
    public function trash(array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->trash($columns));
        } catch (CoreException $exception) {
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Get all soft deleted records.
     *
     * @param  Model|string $id                  The ID of the record.
     * @param  array        $columns             The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of soft deleted records.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error retrieving the soft deleted records.
     */
    public function getTrash($id, array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->getTrash($id, $columns));
        } catch (CoreException $exception) {
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Filter records.
     *
     * @param  array $criteria                   The criteria for filtering the records.
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating whether the permanent deletion of all records was successful.
     *
     * @throws \Core\Utils\Exceptions\ServiceException If there is an error while performing the permanent deletion.
     */
    public function search(array $criteria, array $columns = ['*']): \Illuminate\Http\JsonResponse
    {

        try {
            return JsonResponseTrait::success(data: $this->queryService->where($criteria, $columns));
        } catch (CoreException $exception) {
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
