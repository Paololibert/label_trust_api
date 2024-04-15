<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\Repositories;

use App\Models\Finances\ExerciceComptable;
use Carbon\Carbon;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Enums\StatusExerciceEnum;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\QueryException as CoreQueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\PlansComptable\Accounts\Repositories\AccountReadWriteRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * ***`ExerciceComptableReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the ExerciceComptable $instance data.
 *
 * @package ***`Domains\Finances\ExercicesComptable\Repositories`***
 */
class ExerciceComptableReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * @var AccountReadWriteRepository
     */
    protected $accountRepositoryReadWrite;

    /**
     * Create a new ExerciceComptableReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\ExerciceComptable $model
     * @return void
     */
    public function __construct(ExerciceComptable $model, AccountReadWriteRepository $accountRepositoryReadWrite)
    {
        parent::__construct($model);
        $this->accountRepositoryReadWrite = $accountRepositoryReadWrite;
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
            return parent::create($data);
        } catch (QueryException $exception) {
            throw new CoreQueryException(message: "Error while creating the exercice comptable.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the exercice comptable.", previous: $exception);
        }
    }

    /**
     *
     * This method associates specific accounts with a given Plan Comptable.
     *
     * @param   string                                      $exerciceComptableId        The unique identifier of the Plan Comptable to attach accounts to.
     * @param   array                                       $accountDataArray       The array of account data representing the accounts to be attached.
     *
     * @return  bool                                                                Whether the accounts were attached successfully.
     *
     * @throws  \Core\Utils\Exceptions\QueryException                               If there is an error while attaching accounts.
     * @throws  \Core\Utils\Exceptions\RepositoryException                          If there is an issue with the repository operation.
     */
    public function reportDesSoldesAuxComptes(string $exerciceComptableId, array $accountsDataArray): bool
    {
        try {
            $this->model = $this->find($exerciceComptableId);

            foreach ($accountsDataArray as $key => $accountDataArray) {
                $account = $this->model->plan_comptable->findAccountOrSubAccount(accountNumber: $accountDataArray["account_number"], columns: ["id", "account_number"]);

                if (!$account) throw new ModelNotFoundException("Compte inconnu : {$accountDataArray['account_number']}.", 1);

                if(!$this->model->balances()->where("balanceable_id", $account->id)->first()) $this->model->balances()->create(array_merge($accountDataArray, ["balanceable_id" => $account->id, "balanceable_type" => $account::class]));
                if (isset($accountDataArray["sub_accounts"])) {
                    $this->reportDeSoldeAuxSousCompte(accountsData: $accountDataArray["sub_accounts"], parentAccountNumber: $account->account_number);
                }
            }

            return true;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while attaching accounts to Plan Comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Report de solde aux sous-comptes et aux comptes de sub-divisions
     * 
     * @return void
     */
    private function reportDeSoldeAuxSousCompte($accountsData, string $parentAccountNumber): void
    {
        $query = $this->model->plan_comptable->sub_accounts_and_sub_divisions(query: $this->model->plan_comptable->accounts(), columns: ["id", "account_number"]);

        /* $query = $query->filter(function ($model) use ($parentAccountNumber) {
            // Perform a "where like" operation on the desired attribute
            return stripos($model->account_number, $parentAccountNumber) !== false;
        }); */

        $query = DB::table("plan_comptable_compte_sous_comptes")->select("id", "account_number")->get();
        
        foreach ($accountsData as $key => $subAccountData) {
            $subAccount = $this->model->plan_comptable->findAccountOrSubAccount(query: $query, accountNumber: $subAccountData["account_number"], columns: ["id", "account_number"]);

            if (!$subAccount) throw new ModelNotFoundException("Compte inconnu : {$subAccountData['account_number']}.", 1);

            if(!$this->model->balances()->where("balanceable_id", $subAccount->id)->first()) $this->model->balances()->create(array_merge($subAccountData, ["balanceable_id" => $subAccount->id, "balanceable_type" => $subAccount::class]));

            if (isset($subAccountData["sub_divisions"])) {
                $this->reportDeSoldeAuxSousCompte(accountsData: $subAccountData["sub_divisions"], parentAccountNumber: $subAccount->account_number);
            }
        }
    }

    /**
     * Cloture de solde aux comptes, aux sous-comptes et aux comptes de sub-division
     * 
     * @return bool
     */
    public function clotureDesComptesDunExercice(string $exerciceComptableId, array $data = []): bool
    {
        $this->model = $this->find($exerciceComptableId);

        /* foreach ($this->model->plan_comptable->accounts as $key => $account) {

            $this->model->close_balance()->create(['solde_debit', 'solde_credit' => $account->balance()->where(), 'date_report' => \Carbon\Carbon::now(), 'date_cloture' => \Carbon\Carbon::now(), "ligneable_id" => $account->id, "ligneable_type" => $account::class]);

            if (isset($subAccountData["sub_divisions"])) {
                $this->reportDeSoldeAuxSousCompte($subAccountData["sub_divisions"]);
            }
        } */

        return $this->model->update(["date_fermeture" => \Carbon\Carbon::createFromFormat("d/m/Y", $data["cloture_at"]) ?? \Carbon\Carbon::now(), "status_exercice" => StatusExerciceEnum::CLOSE]);

    }

    /**
     * Report de solde aux sous-comptes et aux comptes de sub-divisions
     * 
     * @return void
     */
    private function clotureDesComptes($accountsData): void
    {
        foreach ($accountsData as $key => $subAccountData) {
            $subAccount = $this->model->plan_comptable->findAccountOrSubAccount(accountNumber: $subAccountData["account_number"], columns: ["id", "account_number"]);

            if (!$subAccount) throw new ModelNotFoundException("Compte inconnu : {$subAccountData['account_number']}.", 1);

            $this->model->balances()->create(array_merge($subAccountData, ["balanceable_id" => $subAccount->id, "balanceable_type" => $subAccount::class]));

            if (isset($subAccountData["sub_divisions"])) {
                $this->clotureDesComptes($subAccountData["sub_divisions"]);
            }
        }
    }

    private function sous()
    {
    }
}
