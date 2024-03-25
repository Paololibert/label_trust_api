<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\Repositories;

use App\Models\Finances\Account;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\Comptes\Repositories\CompteReadWriteRepository;
use Domains\Finances\PlansComptable\Accounts\SubAccounts\Repositories\SubAccountReadWriteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function create(array $data): Model
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
                    }
                }else {

                    $compte = $this->compteReadWriteRepository->create(array_merge($subAccountItem, $subAccountItem["compte_data"]));

                    $this->subAcountRepositoryReadWrite->create(array_merge($subAccountItem, ["sous_compte_id" => $compte->id, "subaccountable_id" => $this->model->id, "subaccountable_type" => $this->model::class]));
                }
            }
    
            return true;
            
        } catch (ModelNotFoundException $exception) {
            throw new QueryException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while attaching taux to category of employee.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while attaching taux to category of employee.", previous: $exception);
        }        
    }

    /**
     * Delete accounts from a Plan Comptable.
     *
     * This method deletes the accounts associated with a given Plan Comptable.
     *
     * @param   string                                      $planComptableId        The unique identifier of the Plan Comptable to delete accounts from.
     * @param   array                                       $deletedAccountIds      The array of IDs of accounts to be deleted.
     *
     * @return  bool                                                                Whether the accounts were deleted successfully.
     *
     * @throws  \Core\Utils\Exceptions\QueryException                               If there is an error while deleting accounts.
     * @throws  \Core\Utils\Exceptions\RepositoryException                          If there is an issue with the repository operation.
     */
    public function deleteSubAccounts(string $accountId, array $deletedSubAccountIds, array $filters = []): bool
    {
        try {

            $query = $this->model;
            $query = $this->find($accountId);

            $filters = array_merge($filters["where"], [["id", "=", $accountId]]);

            if ($filters) {
                foreach ($filters as $filterName => $filter) {
                    foreach ($filter as $condition) {
                        switch ($filterName) {
                            case 'whereIn':
                                $query = $query->{$filterName}($condition[0], $condition[1]);
                                break;

                            default:
                                $query = $query->{$filterName}($condition[0], $condition[1], $condition[2]);
                                
                                break;
                        }
                    }
                }
            }

            // Find the Plan Comptable by ID
            //$query = $this->find($accountId);

            dd($query->get());

            // Soft-delete sub-accounts
            $result = $this->subAcountRepositoryReadWrite->softDelete([], filters: ["where" => [["account_id", "=", $this->model->id]], "whereIn" => [["sous_compte_id", $deletedSubAccountIds]]]);

            return $result;
        } catch (ModelNotFoundException $exception) {
            // Throw a QueryException if the Plan Comptable or any of the accounts are not found
            throw new QueryException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            // Throw a QueryException if there is an error while deleting sub-accounts
            throw new QueryException(message: "Error while deleting sub-accounts from a plan comptable account.", previous: $exception);
        } catch (Throwable $exception) {
            // Throw a RepositoryException if there is an issue with the repository operation
            throw new RepositoryException(message: "Error while deleting sub-accounts from a plan comptable account.", previous: $exception);
        }
    }
    
}