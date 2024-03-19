<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts;

use App\Models\Contract;
use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;
use Core\Utils\DataTransfertObjects\DTOInterface;

/**
 * Interface ***`EmployeeContractuelRESTfulReadWriteServiceContract`***
 *
 * The `EmployeeContractuelRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the EmployeeContractuel module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on EmployeeContractuel resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Employees\EmployeeContractuels\Services\RESTful\Contracts`***
 */
interface EmployeeContractuelRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
    /**
     * Assign a poste to an employeecontractuel and create a new contract and optionally a new salaire.
     *
     * @param DTOInterface $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignmentOfPost(\Core\Utils\DataTransfertObjects\DTOInterface $data): \Illuminate\Http\JsonResponse;

    
    /**
     * Terminate a contract.
     *
     *
     * @param   string            $contractId        The unique identifier of the contract.
     * @param   string            $employeeId        The unique identifier of the employee.
     *
     * @return  \Illuminate\Http\JsonResponse            Whether the contract is terminate successfully.
     */
    public function terminateContract(string $contractId, string $employeeId): \Illuminate\Http\JsonResponse;
    
}