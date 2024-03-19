<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Domains\Employees\EmployeeNonContractuels\Services\RESTful\Contracts\EmployeeNonContractuelRESTfulReadWriteServiceContract;
use Illuminate\Http\Response;

/**
 * The ***`EmployeeNonContractuelRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "EmployeeNonContractuel" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "EmployeeNonContractuel" resource.
 * It implements the `EmployeeNonContractuelRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Employees\EmployeeNonContractuels\Services\RESTful`***
 */
class EmployeeNonContractuelRESTfulReadWriteService extends RestJsonReadWriteService implements EmployeeNonContractuelRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the EmployeeNonContractuelRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

    
    /**
     * Changing Category.
     *
     * @param   string            $employeeId           The unique identifier of the employee.
     * @param   string            $newCategoryId        The unique identifier of the contract. 
     * 
     * @param   \Core\Utils\DataTransfertObjects\ DTOInterface $data               The order data
     * 
     * @return  \Illuminate\Http\JsonResponse           Whether the category is changed successfully.
     */
    public function changeCategoryOfNonContractualEmployee(string $employeeId, string $newCategoryId, DTOInterface $data): \Illuminate\Http\JsonResponse
    {
        $result = $this->readWriteService->getRepository()->changeCategoryOfNonContractualEmployee($employeeId,  $newCategoryId, $data->toArray()); 

        return JsonResponseTrait::success(
            message: 'Category changed successfully',
            data: $result,
            status_code: Response::HTTP_OK
        );
    }
}