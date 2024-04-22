<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeContractuels\Services\RESTful;

use Core\Logic\Services\Contracts\QueryServiceContract;
use Core\Logic\Services\RestJson\RestJsonQueryService;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\ServiceException;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts\EmployeeContractuelRESTfulQueryServiceContract as ContractsEmployeeContractuelRESTfulQueryServiceContract;
use Illuminate\Http\Response;
use Throwable;

/**
 * Class ***`EmployeeContractuelRESTfulQueryService`***
 *
 * The `EmployeeContractuelRESTfulQueryService` class is responsible for providing a RESTful implementation of the query service for the People module.
 * It extends the `RestJsonQueryService` class provided by the Core module and implements the `EmployeeContractuelRESTfulQueryServiceContract` interface.
 *
 * The `EmployeeContractuelRESTfulQueryService` class primarily serves as a wrapper around the underlying query service, providing RESTful capabilities for querying EmployeeContractuel resources.
 *
 * @package ***`\Domains\Employees\EmployeeContractuels\Services\RESTful`***
 */
class EmployeeContractuelRESTfulQueryService extends RestJsonQueryService implements ContractsEmployeeContractuelRESTfulQueryServiceContract
{
    /**
     * Constructor for the EmployeeContractuelRESTfulQueryService class.
     *
     * @param QueryServiceContract $queryService The query service instance to be used.
     */
    public function __construct(QueryServiceContract $queryService)
    {
        parent::__construct($queryService);
    }

    /**
     * List of pay slips
     *
     * @param  string                                   $employeeContractuelId      The unique identifier of the employee contractuel.
     * @return \Illuminate\Http\JsonResponse                                        The JSON response indicating the success of the operation.
     *
     * @throws \Core\Utils\Exceptions\ServiceException                              If there is an issue.
     */
    public function pay_slips(string $employeeContractuelId): \Illuminate\Http\JsonResponse
    {
        try {

            $pay_slips = $this->queryService->getRepository()->find($employeeContractuelId)->pay_slips()->latest()->paginate();

            return JsonResponseTrait::success(
                message: "Fiches de paie",
                data: $pay_slips,
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