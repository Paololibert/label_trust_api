<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts\EmployeeNonContractuelRESTfulQueryServiceContract;
use Illuminate\Http\Response;
use Throwable;

/**
 * Class ***`EmployeeNonContractuelRESTfulQueryService`***
 *
 * The `EmployeeNonContractuelRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the People module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `EmployeeNonContractuelRESTfulQueryServiceContract` interface.
 *
 * The `EmployeeNonContractuelRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying EmployeeNonContractuel resources.
 *
 * @package ***`\Domains\Employees\EmployeeNonContractuels\Services\RESTful`***
 */
class EmployeeNonContractuelRESTfulQueryService extends RestJsonQueryService implements EmployeeNonContractuelRESTfulQueryServiceContract
{
    /**
     * Constructor for the EmployeeNonContractuelRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

    /**
     * List of invoices
     *
     * @param  string                                   $employeeId     The unique identifier of the employee.
     * @return \Illuminate\Http\JsonResponse                            The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                  If there is an issue.
     */
    public function invoices(string $employeeId): \Illuminate\Http\JsonResponse
    {
        try {

            $invoices = $this->queryService->getRepository()->find($employeeId)->invoices;

            return JsonResponseTrait::success(
                message: 'Invoice generated successfully',
                data: $invoices,
                status_code: Response::HTTP_OK
            );
        } catch (CoreException $exception) {

            // Throw a ServiceException if there is an issue with updating the accounts
            throw new ServiceException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        
        } catch (Throwable $exception) {
            // Throw a ServiceException if there is an issue with updating the accounts
            throw new ServiceException(message: $exception->getMessage(), code: $exception->getCode(), previous: $exception);
        }
    }
}