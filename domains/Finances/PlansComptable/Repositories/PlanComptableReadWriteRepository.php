<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Repositories;

use App\Http\Resources\Finances\PlanComptableResource;
use App\Imports\AccountsImport;
use App\Imports\ImportPlan;
use App\Imports\ImportPlans;
use App\Models\Finances\PlanComptable;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\CategoriesDeCompte\Repositories\CategorieDeCompteReadWriteRepository;
use Domains\Finances\ClassesDeCompte\Repositories\ClasseDeCompteReadWriteRepository;
use Domains\Finances\Comptes\Repositories\CompteReadWriteRepository;
use Domains\Finances\PlansComptable\Accounts\Repositories\AccountReadWriteRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

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
     * @return AccountReadWriteRepository
     */
    public function getAccountRepositoryReadWrite()
    {
        return $this->accountRepositoryReadWrite;
    }

    /**
     * @return CompteRepositoryReadWrite
     */
    public function getCompteRepositoryReadWrite()
    {
        return $this->compteRepositoryReadWrite;
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
                    } else if (isset($account_data['compte_data'])) {
                        // If 'compte_id' is not set, create the related Compte first, then create the account
                        $compte = $this->compteRepositoryReadWrite->firstOrCreate(["name" => strtolower($account_data["compte_data"]["name"])], $account_data['compte_data']);

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

            //if($this->model->est_valider) throw new Exception("Le plan comptable a deja ete valider", 1);

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
                } else if (isset($accountItemData['compte_data'])) {
                    if (!isset($accountItemData['plan_comptable_id'])) {
                        $accountItemData['plan_comptable_id'] = $this->model->id;
                    }
                    // If 'compte_id' is not set, create the related Compte first, then create the account
                    $compte = $this->compteRepositoryReadWrite->firstOrCreate(["name" => strtolower($accountItemData["compte_data"]["name"])], $accountItemData['compte_data']);

                    //$compte = $this->compteRepositoryReadWrite->create($accountItemData['compte_data']);
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

            if ($this->model->est_valider) throw new Exception("Le plan comptable a deja ete valider", 1);

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

            if ($this->model->est_valider) throw new Exception("Le plan comptable a deja ete valider", 1);

            // Soft-delete accounts
            $result = $this->accountRepositoryReadWrite->softDelete([], filters: ["where" => [["plan_comptable_id", "=", $this->model->id]], "whereIn" => [["compte_id", $deletedAccountIds]]]);

            return $result;
        } catch (CoreException $exception) {
            // Throw a RepositoryException if there is an issue with the repository operation
            throw new RepositoryException(message: "Error while updating accounts in a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Validate 
     *
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

    /**
     * Importer un plan comptabler
     * 
     * @param array $data
     * @return PlanComptableResource
     */
    public function import(array $data): PlanComptableResource
    {

        try {

            // Import the file using YourImportClass
            $import = new AccountsImport();

            // Load the Excel file
            $result = Excel::toArray($import, $data["plan"]);

            $data["accounts"] = $this->structure($result[0]);

            $plan_comptable = $this->create($data);

            return new PlanComptableResource($plan_comptable);

            //$plan_repository = app(PlanComptableReadWriteRepository::class);

            //$response = $plan_repository->create($plan);

            //$plan_comptable = $this->plan_comptable_repository->create($plan);

            //$accounts[] = Excel::toArray((new ImportPlans(plan_comptable_name: $data["name"], planComptableRepository: $this))->onlySheets('Plan comptable général', 'Plan analytique'), $data["plan"]);

        } catch (CoreException $exception) {
            // Throw a RepositoryException if there is an issue with the repository operation
            throw new RepositoryException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }


    /**
     * @param Collection $rows
     *
     * @return array
     */
    protected function structure(array $rows): array
    {
        $groupedAccounts = [];
        $currentClasse = null;

        $index = $classe_key = 0;

        foreach ($rows as $row) {

            if (is_numeric($row[0])/*  || is_string($row[0]) */) { // Check if the first column contains an account number

                if (!isset($row[1]) || !isset($row[2]) || !isset($row[3])) {
                    break;
                } else if (is_null($row[1]) || is_null($row[2]) || is_null($row[3])) {
                    break;
                }

                // It's an account row
                $accountNumber = $row[0];
                $formattedAccount = [
                    'account_number' => $accountNumber,
                    'compte_data' => [
                        'type_de_compte'            => $row[3],
                        'name'                      => $row[1],
                        'categorie_de_compte_id'    => app(CategorieDeCompteReadWriteRepository::class)->getModel()->firstOrCreate(['name' => strtolower($row[2])], ['name' => $row[2]])->id
                    ]
                ];


                // Check if the account has a parent
                if (strlen((string) $accountNumber) > 2) {
                    $parentAccountNumber = substr((string) $accountNumber, 0, -1);
                    $parentClassNumber = (int) substr((string) $parentAccountNumber, 0, 1);

                    // Check if it's a sub-division
                    if (strlen((string) $accountNumber) >= 4) {
                        // Find the parent of the sub-division

                        $this->findParent(groupedAccounts: $groupedAccounts[$classe_key], parentClassNumber: $parentClassNumber, parentAccountNumber: $parentAccountNumber, accountNumber: $accountNumber, formattedSubDivision: $formattedAccount, maxDepth: strlen((string) $parentAccountNumber) - 2);
                    } else {
                        // It's a sub-account
                        $groupedAccounts[$classe_key]['accounts'][$parentAccountNumber]['sub_accounts'][$accountNumber] = $formattedAccount;
                    }
                } else {
                    // It's a parent account

                    $formattedAccount = array_merge($formattedAccount, ["classe_id" => $currentClasse['classe_id']]);

                    // Add the account to the current classe
                    $groupedAccounts[$classe_key]['classe_intitule']                        = $currentClasse['intitule'];
                    $groupedAccounts[$classe_key]['class_number']                           = $currentClasse['class_number'];
                    $groupedAccounts[$classe_key]['accounts'][$accountNumber]               = array_merge($formattedAccount, ["classe_id" => $currentClasse['classe_id']]);

                    $groupedAccounts[$classe_key]['accounts'][$accountNumber]['classe_id']  = $currentClasse['classe_id'];
                    //$groupedAccounts[$currentClasse['class_number']]['accounts'][$accountNumber] = $formattedAccount;
                }
            } else if (!is_null($row[0])) {

                if (strpos($row[0], 'CLASSE') !== false) {
                    $class_number = (int) substr((string) strtolower($row[0]), strlen(strtolower("CLASSE "))); //$this->extractIntegerFromString($row[0]);

                    // If not, it's a classe row
                    $currentClasse = [
                        'class_number' => $row[0],
                        'intitule' => $row[1]
                    ];

                    $classe = app(ClasseDeCompteReadWriteRepository::class)->getModel()->firstOrCreate(['class_number' => $class_number], array_merge($currentClasse, ["class_number" => $class_number]));

                    $currentClasse["classe_id"] = $classe->id;

                    $classe_key = ++$index;
                }
            }
        }

        return collect($groupedAccounts)->pluck("accounts")->collapse()->toArray();

        /*
            //$dto = new CreatePlanComptableDTO(data: $plan);

            request()->request->add($plan);

            $createRequest = app(ResourceRequest::class, ["request" => request(), "dto" => new CreatePlanComptableDTO/* , "data" => $plan, "rules" => $dto->rules() *//*]);
            $createRequest = new ResourceRequest(request: request(), dto: new CreatePlanComptableDTO(data: $plan, rules:$dto->rules()));

            // Validate the incoming request using the ResourceRequest rules
            if ($createRequest) {
                $createRequest->validate($createRequest->rules());
            }
        */
    }

    // Function to recursively find the parent of a sub-division
    /**
     * 
     * @param array $groupedAccounts
     * @param int $parentClassNumber
     * @param int|string $parentAccountNumber
     * @param int|string $accountNumber
     * @param array $formattedSubDivision
     * @param int $maxDepth
     * 
     * @return void
     */
    private function findParent(&$groupedAccounts, int $parentClassNumber, int|string $parentAccountNumber, int|string $accountNumber, array $formattedSubDivision, int $maxDepth = 5)
    {
        // Check if the max depth has been reached
        if ($maxDepth < 0) {
            return;
        }

        if (isset($groupedAccounts["accounts"])) {

            $parent = substr((string) $parentAccountNumber, 0, 2);

            while (strlen((string) $parent) > 2) {
                $parent = substr((string) $parent, 0, -1);
            }

            $this->findParent(groupedAccounts: $groupedAccounts["accounts"][$parent]["sub_accounts"], parentClassNumber: $parentClassNumber, parentAccountNumber: $parentAccountNumber, accountNumber: $accountNumber, formattedSubDivision: $formattedSubDivision, maxDepth: $maxDepth - 1);
        } else {

            if (isset($groupedAccounts[$parentAccountNumber]) && $maxDepth === 0) {

                // Add the sub-division to the parent sub-account's sub_divisions array
                $groupedAccounts[$parentAccountNumber]['sub_divisions'][$accountNumber] = $formattedSubDivision;
            } else {
                $parent = substr((string) $parentAccountNumber, 0, -1);

                while (!(strlen((string) $parent) - 2 === $maxDepth)) {
                    $parent = substr((string) $parent, 0, -1);
                }

                $this->findParent(groupedAccounts: $groupedAccounts[$parent]['sub_divisions'], parentClassNumber: $parentClassNumber, parentAccountNumber: $parentAccountNumber, accountNumber: $accountNumber, formattedSubDivision: $formattedSubDivision, maxDepth: $maxDepth - 1);
            }
        }
    }
}
