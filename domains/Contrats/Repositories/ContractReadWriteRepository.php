<?php

declare(strict_types=1);

namespace Domains\Contrats\Repositories;

use App\Models\Contract;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Enums\StatutContratEnum;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Exception;
use Throwable;
/**
 * ***`ContractReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Contract $instance data.
 *
 * @package ***`Domains\Contrats\Repositories`***
 */
class ContractReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new ContractReadWriteRepository instance.
     *
     * @param  \App\Models\Contract $model
     * @return void
     */
    public function __construct(Contract $model)
    {
        parent::__construct($model);
    }

    
    /**
     * Create a new record.
     *
     * @param  array $data         The data for creating the record.
     * @return Contract               The created record.
     *
     * 
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function create(array $data): Contract
    {
        try {

            $theparent =  $this->model = parent::create($data);
            
            if (!isset($data['poste_salaire_id'])){
                $salary = $theparent->salaires()->create($data);
            }

            return $this->model->refresh();
            
        } catch (QueryException $exception) {
            
            throw new QueryException(message: "Error while creating the record.", previous: $exception);
            
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }

    
    /**
     * Create a new record.
     *
     * @param  string $employee_contractuel_id         The employee id .
     * 
     * @param  string $employee_contractuel_id         The contract id.
     * 
     * @param  StatutContratEnum $status               The satatus of the contract.
     * 
     * @param  Carbon|null $date_fin                   The ending date which is default null.
     * 
     * @return bool                                    The return of the function.
     *
     * 
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function manageStatus(string $contract_id,string $employee_contractuel_id, StatutContratEnum $status, $date_fin = null):bool
    {
        $contract = $this->find($contract_id);
        
        $exist = $contract->employee_contractuel_id === $employee_contractuel_id;
        
        if (!$exist) throw new Exception("The provided contract does not belong to the employee.");
      
        $contract->date_fin = $date_fin;
        $contract->contract_status = $status;
        $contract->save();
        
        return true;
    }
}