<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Repositories;

use App\Models\Finances\PlanComptable;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\Comptes\Repositories\CompteReadWriteRepository;
use Domains\Finances\PlansComptable\Accounts\Repositories\AccountReadWriteRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;

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
    public function create(array $data): Model
    {
        try {
            $this->model = parent::create($data);

            if (isset($data['accounts'])) {
                foreach ($data['accounts'] as $account_data) {
                    $account_data = array_merge($account_data, ["plan_comptable_id" => $this->model->id]);
                    if (isset($account_data['compte_id'])) {
                        $this->accountRepositoryReadWrite->create($account_data);
                    } else {
                        $compte = $this->compteRepositoryReadWrite->create($account_data['compte_data']);

                        $this->attachAccounts($this->model->id, [array_merge($account_data, ["compte_id" => $compte->id])]);
                    }
                }
            }

            return $this->model->refresh();
        } catch (CoreException $exception) {
            // Throw a RepositoryException if there is an issue with the repository operation
            throw new RepositoryException(message: "Error while creating accounts records in a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Attach accounts to a Plan Comptable.
     *
     * This method associates specific accounts with a given Plan Comptable.
     *
     * @param   string                                      $planComptableId        The unique identifier of the Plan Comptable to attach accounts to.
     * @param   array                                       $accountDataArray       The array of account data representing the accounts to be attached.
     *
     * @return  bool                                                                Whether the accounts were attached successfully.
     *
     * @throws  \Core\Utils\Exceptions\QueryException                               If there is an error while attaching accounts.
     * @throws  \Core\Utils\Exceptions\RepositoryException                          If there is an issue with the repository operation.
     */
    public function attachAccounts(string $planComptableId, array $accountDataArray): bool
    {
        try {
            // Find the Plan Comptable by ID
            $this->model = $this->find($planComptableId);

            if($this->model->est_valider) throw new Exception("Le plan comptable a deja ete valider", 1);

            // Iterate through each account data item
            foreach ($accountDataArray as $accountItemData) {
                // Check if the 'compte_id' key is set in the account data
                if (isset($accountItemData['compte_id'])) {
                    // Check if the relation exists, if not, create the account
                    if (!parent::relationExists(relation: $this->model->comptes(), ids: [$accountItemData['compte_id']], isPivot: true)) {

                        if (!isset($accountItemData['plan_comptable_id'])) {
                            $accountItemData['plan_comptable_id'] = $this->model->id;
                        }
                        $this->accountRepositoryReadWrite->create($accountItemData);
                    }
                } else {
                    if (!isset($accountItemData['plan_comptable_id'])) {
                        $accountItemData['plan_comptable_id'] = $this->model->id;
                    }
                    // If 'compte_id' is not set, create the related Compte first, then create the account
                    $compte = $this->compteRepositoryReadWrite->create($accountItemData['compte_data']);
                    $this->accountRepositoryReadWrite->create(array_merge($accountItemData, ["compte_id" => $compte->id]));
                }
            }

            return true;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while attaching accounts to Plan Comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Update accounts in a Plan Comptable.
     *
     * This method updates the accounts associated with a given Plan Comptable.
     *
     * @param   string                                      $planComptableId        The unique identifier of the Plan Comptable to update accounts for.
     * @param   array                                       $updatedAccountsData    The array of updated account data representing the changes to be made.
     *
     * @return  bool                                                                Whether the accounts were updated successfully.
     *
     * @throws  \Core\Utils\Exceptions\QueryException                               If there is an error while updating accounts.
     * @throws  \Core\Utils\Exceptions\RepositoryException                          If there is an issue with the repository operation.
     */
    public function updateAccounts(string $planComptableId, array $updatedAccountsData): bool
    {
        try {
            // Find the Plan Comptable by ID
            $this->model = $this->find($planComptableId);

            if($this->model->est_valider) throw new Exception("Le plan comptable a deja ete valider", 1);

            $result = $this->accountRepositoryReadWrite->updateMultiple($updatedAccountsData, filters: ["where" => [["plan_comptable_id", "=", $this->model->id]]]);

            return count($result) === count($updatedAccountsData);
        } catch (CoreException $exception) {
            // Throw a RepositoryException if there is an issue with the repository operation
            throw new RepositoryException(message: "Error while updating accounts in a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
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
    public function deleteAccounts(string $planComptableId, array $deletedAccountIds): bool
    {
        try {
            // Find the Plan Comptable by ID
            $this->model = $this->find($planComptableId);

            if($this->model->est_valider) throw new Exception("Le plan comptable a deja ete valider", 1);

            // Soft-delete accounts
            $result = $this->accountRepositoryReadWrite->softDelete([], filters: ["where" => [["plan_comptable_id", "=", $this->model->id]], "whereIn" => [["compte_id", $deletedAccountIds]]]);

            return $result;
        } catch (CoreException $exception) {
            // Throw a RepositoryException if there is an issue with the repository operation
            throw new RepositoryException(message: "Error while updating accounts in a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Delete accounts from a Plan Comptable.
     *
     * This method deletes the accounts associated with a given Plan Comptable.
     *
     * @param   string                                      $planComptableId        The unique identifier of the Plan Comptable to delete accounts from.
     *
     * @return  bool                                                                Whether the accounts were deleted successfully.
     *
     * @throws  \Core\Utils\Exceptions\QueryException                               If there is an error while deleting accounts.
     * @throws  \Core\Utils\Exceptions\RepositoryException                          If there is an issue with the repository operation.
     */
    public function validatePlanComptable(string $planComptableId): bool
    {
        try {
            // Find the Plan Comptable by ID
            $result = $this->update($planComptableId, ["est_valider" => true]);

            return $result ? true : false;
        } catch (CoreException $exception) {
            // Throw a RepositoryException if there is an issue with the repository operation
            throw new RepositoryException(message: "Error while updating accounts in a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
