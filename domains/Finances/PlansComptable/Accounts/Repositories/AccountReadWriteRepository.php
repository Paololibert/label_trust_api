<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\Repositories;

use App\Models\Finances\Account;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\Comptes\Repositories\CompteReadWriteRepository;
use Domains\Finances\PlansComptable\SubAccounts\Repositories\SubAccountReadWriteRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Throwable;

/**
 * ***`AccountReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Account $instance data.
 *
 * @package ***`Domains\Finances\PlansComptable\Accounts\Repositories`***
 */
class AccountReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * @var CompteReadWriteRepository
     */
    protected $compteReadWriteRepository;

    /**
     * @var SubAccountReadWriteRepository
     */
    protected $subAcountRepositoryReadWrite;

    /**
     * Create a new AccountReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\Account $model
     * @return void
     */
    public function __construct(Account $model, CompteReadWriteRepository $compteReadWriteRepository, SubAccountReadWriteRepository $subAcountRepositoryReadWrite)
    {
        parent::__construct($model);
        $this->compteReadWriteRepository = $compteReadWriteRepository;
        $this->subAcountRepositoryReadWrite = $subAcountRepositoryReadWrite;
    }

    /**
     * Create a new record.
     *
     * @param  array $data         The data for creating the record.
     * @return Account               The created record.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function create(array $data): Account
    {
        try {

            $this->model = parent::create($data);

            if(isset($data['sub_accounts'])){
                $this->attachSubAccounts($this->model->id, $data['sub_accounts']);
            }

            return $this->model->refresh();
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }

    /**
     * Attach subaccounts.
     *
     * This method associates specific taux with a given category of employee.
     *
     * @param   string      $accountId              The unique identifier of the Account.
     * @param   array       $subAccountDataArray    The array of access identifiers representing the taux to be attached.
     *
     * @return  bool                                Whether the taux were attached successfully.
     */
    public function attachSubAccounts(string $accountId, array $subAccountDataArray): bool
    {
        try {

            $this->model = $this->find($accountId);

            foreach ($subAccountDataArray as $subAccountItem) {

                if(isset($subAccountItem['sous_compte_id'])){
                    if (!parent::relationExists(relation: $this->model->sous_comptes(), ids: [$subAccountItem['sous_compte_id']], isPivot: false)) {
                        
                        // Attach the sous compte to principal compte
                        $this->subAcountRepositoryReadWrite->create(array_merge($subAccountItem, ["subaccountable_id" => $this->model->id, "subaccountable_type" => $this->model::class]));
                        //$this->model->sous_comptes()->syncWithoutDetaching([$subAccountItem['sous_compte_id'] => $subAccountItem]);
                    }
                }else {

                    $compte = $this->compteReadWriteRepository->create(array_merge($subAccountItem, $subAccountItem["compte_data"]));

                    $this->subAcountRepositoryReadWrite->create(array_merge($subAccountItem, ["sous_compte_id" => $compte->id, "subaccountable_id" => $this->model->id, "subaccountable_type" => $this->model::class]));

                    //array_merge($subAccountItem, ["compte_id" => $compte->id]);
                    
                    //$this->model->sous_comptes()->syncWithoutDetaching([$compte->id => $subAccountItem]);
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