<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\Repositories;

use App\Models\Finances\Account;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\NotFoundException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\Comptes\Repositories\CompteReadWriteRepository;
use Domains\Finances\ExercicesComptable\Repositories\ExerciceComptableReadWriteRepository;
use Domains\Finances\PlansComptable\Accounts\SubAccounts\Repositories\SubAccountReadWriteRepository;
use Illuminate\Database\Eloquent\Model;

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
        $this->compteReadWriteRepository            = $compteReadWriteRepository;
        $this->subAcountRepositoryReadWrite         = $subAcountRepositoryReadWrite;
    }

    /**
     * @return SubAccountReadWriteRepository
     */
    public function getSubAcountRepositoryReadWrite()
    {
        return $this->subAcountRepositoryReadWrite;
    }

    /**
     * @return CompteReadWriteRepository
     */
    public function getCompteReadWriteRepository()
    {
        return $this->compteReadWriteRepository;
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

            if (isset($data['sub_accounts'])) {
                $this->attachSubAccounts($this->model->id, $data['sub_accounts']);
            }

            return $this->model->refresh();
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while creating accounts of a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
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
    public function attachSubAccounts(string $accountId, array $subAccountDataArray, array $filters = []): bool
    {
        try {

            $query = $this->model;

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

            $this->model = $query->where("id", $accountId)->first();

            foreach ($subAccountDataArray as $key => $subAccountItem) {

                if (!is_null($subAccountItem)) {

                    if (isset($subAccountItem['sous_compte_id'])) {
                        if (!parent::relationExists(relation: $this->model->sous_comptes(), ids: [$subAccountItem['sous_compte_id']], isPivot: false)) {

                            // Attach the sous compte to principal compte                        
                            $this->subAcountRepositoryReadWrite->create(array_merge($subAccountItem, ["subaccountable_id" => $this->model->id, "subaccountable_type" => $this->model::class]));
                        }
                    } else if (isset($subAccountItem['compte_data'])) {
                        $compte = $this->compteReadWriteRepository->firstOrCreate(["name" => strtolower($subAccountItem["compte_data"]["name"])], array_merge($subAccountItem, $subAccountItem["compte_data"]));

                        $this->subAcountRepositoryReadWrite->create(array_merge($subAccountItem, ["sous_compte_id" => $compte->id, "subaccountable_id" => $this->model->id, "subaccountable_type" => $this->model::class]));
                    }
                }
            }

            return true;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while attaching sub-accounts to a plan comptable account." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Update sub-accounts of a plan comptable account.
     *
     * This method updates the sub-accounts associated with a given plan comptable account.
     *
     * @param   string                                      $accountId                  The unique identifier of the plan comptable account of which sub-accounts will be update.
     * @param   array                                       $updatedSubAccountsData     The array of updated sub-account data representing the changes to be made.
     *
     * @return  bool                                                                    Whether the sub-accounts were updated successfully.
     *
     * @throws  \Core\Utils\Exceptions\QueryException                                   If there is an error while updating sub-accounts.
     * @throws  \Core\Utils\Exceptions\RepositoryException                              If there is an issue with the repository operation.
     */
    public function updateSubAccounts(string $accountId, array $updatedSubAccountsData, array $filters = []): bool
    {
        try {

            $query = $this->model;

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

            $this->model = $query->where("id", $accountId)->first();

            if (!$this->model) throw new NotFoundException("Error Processing Request", 1);

            $result = $this->subAcountRepositoryReadWrite->updateMultiple($updatedSubAccountsData, filters: ["where" => [["subaccountable_id", "=", $this->model->id]]]);

            return count($result) === count($updatedSubAccountsData);
        } catch (CoreException $exception) {
            // Throw a RepositoryException if there is an issue with the repository operation
            throw new RepositoryException(message: "Error while updating accounts in a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Delete sub-accounts from a plan comptable account.
     *
     * This method deletes the sub-accounts associated with a given plan comptable account.
     *
     * @param   string                                      $accountId                  The unique identifier of the plan comptable account sub-accounts will be delete from.
     * @param   array                                       $deletedSubAccountIds       The array of IDs of sub-accounts to be deleted.
     *
     * @return  bool                                                                    Whether the sub-accounts were deleted successfully.
     *
     * @throws  \Core\Utils\Exceptions\QueryException                                   If there is an error while deleting sub-accounts.
     * @throws  \Core\Utils\Exceptions\RepositoryException                              If there is an issue with the repository operation.
     */
    public function deleteSubAccounts(string $accountId, array $deletedSubAccountIds, array $filters = []): bool
    {
        try {

            $query = $this->model;

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

            $this->model = $query->where("id", $accountId)->first();

            if (!$this->model) throw new NotFoundException("Error Processing Request", 1);

            // Soft-delete sub-accounts
            $result = $this->subAcountRepositoryReadWrite->softDelete([], filters: ["where" => [["subaccountable_id", "=", $this->model->id]], "whereIn" => [["sous_compte_id", $deletedSubAccountIds]]]);

            return $result;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while deleting sub-accounts from a plan comptable account." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Report de solde a un compte
     *
     * @param   string                                      $accountId              The unique identifier of the account.
     * @param   array                                       $balanceArrayData       The balance data.
     *
     * @return  bool                                                                Whether the account balance are report.
     *
     * @throws  \Core\Utils\Exceptions\QueryException                               If there is an error while reporting account balance.
     * @throws  \Core\Utils\Exceptions\RepositoryException                          If there is an issue with the repository operation.
     */
    public function reportDeSolde(string $accountId, array $balanceArrayData): bool
    {
        try {
            // Find the account by ID
            $this->model = $this->model->find($accountId);

            //change the account balance
            $this->model->balances()->create($balanceArrayData);

            return true;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while reporting an account balance." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
