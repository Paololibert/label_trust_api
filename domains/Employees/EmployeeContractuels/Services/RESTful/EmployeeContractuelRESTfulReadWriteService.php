<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeContractuels\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts\EmployeeContractuelRESTfulReadWriteServiceContract as ContractsEmployeeContractuelRESTfulReadWriteServiceContract;

use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Helpers\Responses\Json\JsonResponseTrait;
use Illuminate\Http\Response;

/**
 * The ***`EmployeeContractuelRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "EmployeeContractuel" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "EmployeeContractuel" resource.
 * It implements the `EmployeeContractuelRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Employees\EmployeeContractuels\Services\RESTful`***
 */
class EmployeeContractuelRESTfulReadWriteService extends RestJsonReadWriteService implements ContractsEmployeeContractuelRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the EmployeeContractuelRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
        
    }
    
    /**
     * Assign a poste to an employeecontractuel and create a new contract and optionally a new salaire.
     *
     * @param \Core\Utils\DataTransfertObjects\ DTOInterface $data
     * @return  \Illuminate\Http\JsonResponse    
     */
    public function assignmentOfPost(DTOInterface $data): \Illuminate\Http\JsonResponse{
        $result = $this->queryService->getRepository()->assignmentOfPost($data->toArray()); 

        return JsonResponseTrait::success(
            message: 'New Post is assign successfully',
            data: $result,
            status_code: Response::HTTP_CREATED
        );
    }

    /**
     * Terminate a contract.
     *
     *
     * @param   string            $contractId        The unique identifier of the contract.
     * @param   string            $employeeId        The unique identifier of the employee.
     *
     * @return  \Illuminate\Http\JsonResponse        Whether the contract is terminate successfully.
     */
    public function terminateContract(string $contractId, string $employeeId): \Illuminate\Http\JsonResponse
    {
        $result = $this->readWriteService->getRepository()->terminateContract($contractId,$employeeId); 

        return JsonResponseTrait::success(
            message: 'Contract terminate successfully',
            data: $result,
            status_code: Response::HTTP_OK
        );
    }
}