<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeContractuels\Repositories;

use App\Models\EmployeeContractuel;

use App\Models\Poste;
use App\Models\Contract;
use App\Models\Salaire;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\DataTransfertObjects\DTOInterface;
use Core\Utils\Enums\StatutContratEnum;
use Domains\Contrats\Repositories\ContractReadWriteRepository;
use Exception;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Throwable;

/**
 * ***`EmployeeContractuelReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the EmployeeContractuel $instance data.
 *
 * @package ***`Domains\Employees\EmployeeContractuels\Repositories`***
 */
class EmployeeContractuelReadWriteRepository extends EloquentReadWriteRepository
{


    protected ContractReadWriteRepository $contractReadWriteRepository;
        /**
     * Create a new EmployeeContractuelReadWriteRepository instance.
     *
     * @param  \App\Models\EmployeeContractuel $model
     * @return void
     */

    public function __construct(EmployeeContractuel $model, ContractReadWriteRepository $contractReadWriteRepository)
    {
        parent::__construct($model);
        $this->contractReadWriteRepository = $contractReadWriteRepository;
    }

    /**
     * Assign a poste to an employeecontractuel and create a new contract and optionally a new salaire.
     *
     * @param  array $data
     * @return Contract
     * @throws QueryException
     * @throws RepositoryException
     * @throws Exception
     */
    public function assignmentOfPost(array $data): Contract
    {
        try {

            $existingContract = $this->contractReadWriteRepository->find($data['contract_id']);
    
            if ($existingContract->employee_contractuel_id != $data['employee_contractuel_id']) {
                throw new Exception("The provided contract does not belong to the employee.");
            }
            $date_fin = now();
            $this->contractReadWriteRepository->manageStatus($data['contract_id'], $data['employee_contractuel_id'], StatutContratEnum::TERMINER, $date_fin);
    
            // create new contract
            $contract = $this->contractReadWriteRepository->create($data);
    
            // Get the employee
            $employee = $this->find($data['employee_contractuel_id']);

            //attach the contract to the employee
            $employee->contracts()->save($contract);
    
            // create the new salary if poste salary is not include in the request
            if (!empty($data['montant'])) {
                unset($data['date_fin']);
                $data['contract_id'] = $contract->id;
                $contract->salaires()->create($data);
            }
    
            return $contract;
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }
    

    /**
     * Terminate a contract.
     *
     *
     * @param   string      $contractId        The unique identifier of the contract.
     * @param   string      $employeeId        The unique identifier of the employee.
     *
     * @return  bool                           Whether the contract is terminate successfully.
     */
    public function terminateContract(string $contractId, $employeeId): bool
    {
        try {

            $employee = $this->model::findOrFail($employeeId);

            $contract = $employee->contracts()->findOrFail($contractId);
            
            if ($contract->contract_status === StatutContratEnum::RESILIER) {
                return true;
            }

            $date_fin = now();
            
            $this->contractReadWriteRepository->manageStatus($contractId, $employeeId, StatutContratEnum::RESILIER, $date_fin);

            return true;

        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }
}