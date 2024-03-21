<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Repositories;

use App\Models\Finances\PlanComptable;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\Comptes\Repositories\CompteReadWriteRepository;
use Domains\Finances\PlansComptable\Accounts\Repositories\AccountReadWriteRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

/**
 * ***`PlanComptableReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the PlanComptable $instance data.
 *
 * @package ***`Domains\Finances\PlansComptable\Repositories`***
 */
class PlanComptableReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * @var CompteReadWriteRepository
     */
    protected $compteRepositoryReadWrite;

    /**
     * @var AccountReadWriteRepository
     */
    protected $accountRepositoryReadWrite;

    /**
     * Create a new PlanComptableReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\PlanComptable $model
     * @return void
     */
    public function __construct(PlanComptable $model, CompteReadWriteRepository $compteRepositoryReadWrite, AccountReadWriteRepository $accountRepositoryReadWrite)
    {
        parent::__construct($model);
        $this->accountRepositoryReadWrite = $accountRepositoryReadWrite;
        $this->compteRepositoryReadWrite = $compteRepositoryReadWrite;
    }

    /**
     * Create a new record.
     *
     * @param  array $data         The data for creating the record.
     * @return Model               The created record.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function create(array $data): PlanComptable
    {
        try {
            $this->model = parent::create($data);

            foreach ($data['accounts'] as $account_data) {
                $account_data = array_merge($account_data, ["plan_comptable_id" => $this->model->id]);
                if(isset($account_data['compte_id'])){
                    $this->accountRepositoryReadWrite->create($account_data);

                    /*
                        $this->model->accounts()->create($account_data);

                        if(!isset(request()['sub_accounts'])){
                            $this->accountRepositoryReadWrite->attachSubAccounts($account->id, $account_data);
                        }
                    */
                }
                else{
                    $compte = $this->compteRepositoryReadWrite->create($account_data['compte_data']);
                    
                    $this->attachAccounts($this->model->id, [array_merge($account_data, ["compte_id" => $compte->id])]);
                }
            }

            return $this->model->refresh();
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }

    /**
     * Attach accounts.
     *
     * This method associates specific taux with a given category of employee.
     *
     * @param   string      $planComptableId              The unique identifier of the plan.
     * @param   array       $subAccountDataArray    The array of access identifiers representing the taux to be attached.
     *
     * @return  bool                                Whether the taux were attached successfully.
     */
    public function attachAccounts(string $planComptableId, array $accountDataArray): bool
    {
        try {

            $this->model = $this->find($planComptableId);

            foreach ($accountDataArray as $accountItemData) {
                if(isset($accountItemData['compte_id'])){
                    //$this->accountRepositoryReadWrite->attachSubAccounts($this->model->id, $accountItemData['sub_accounts']);
                    //$account = $this->model->accounts()->create($account_data);
                    if (!parent::relationExists(relation: $this->model->comptes(), ids: [$accountItemData['compte_id']], isPivot: true)) {
                        
                        $this->accountRepositoryReadWrite->create($accountItemData);
                    }
                }else {

                    //dd($accountItemData);

                    $compte = $this->compteRepositoryReadWrite->create($accountItemData['compte_data']);

                    $this->accountRepositoryReadWrite->create(array_merge($accountItemData, ["compte_id" => $compte->id]));

                    //$account = $this->accountRepositoryReadWrite->create(array_merge($accountItemData, ["plan_comptable_id" => $this->model->id]));
                    
                    //return $this->model->sous_comptes()->syncWithoutDetaching($accountItemData['compte_id'], array_merge($accountItemData, ["compte_id" => $compte->id])) ? true : false;
                }
            }
    
            return false; // Taux is already attached
            
        } catch (ModelNotFoundException $exception) {
            throw new QueryException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while attaching taux to category of employee.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while attaching taux to category of employee.", previous: $exception);
        }        
    }
    
}