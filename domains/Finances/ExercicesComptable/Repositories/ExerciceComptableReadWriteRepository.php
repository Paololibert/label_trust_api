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
use Illuminate\Database\Eloquent\Collection;
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
            $subAccount = $this->model->plan_comptable->findAccountOrSubAccount(accountNumber: $subAccountData["account_number"], columns: ["id", "account_number"]);

            if (!$subAccount) throw new ModelNotFoundException("Compte inconnu : {$subAccountData['account_number']}.", 1);

            if(!$this->model->balances()->where("balanceable_id", $subAccount->id)->first()) $this->model->balances()->create(array_merge($subAccountData, ["balanceable_id" => $subAccount->id, "balanceable_type" => get_class($subAccount)]));

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

        $start_at = \Carbon\Carbon::parse($this->model->date_ouverture)->format("Y-m-d");
        
        $end_at   = ($this->model->fiscal_year . "-" . $this->model->periode_exercice->date_fin_periode->format('m-d'));

        foreach ($this->model->plan_comptable->accounts as $key => $account) {
            
            if(!$account->close_balance()->where("exercice_comptable_id", $this->model->id)->first()){

                $solde_debiteur = $account->balanceDeCompte(type: "debiteur", exercice_comptable_id: $this->model->id, start_at: $start_at, end_at: $end_at);
                $solde_crediteur = $account->balanceDeCompte(type: "crediteur", exercice_comptable_id: $this->model->id, start_at: $start_at, end_at: $end_at);

                $mouv_debiteur = $account->mouvementDebit(exercice_comptable_id: $this->model->id, start_at: $start_at, end_at: $end_at);
                $mouv_crediteur = $account->mouvementCredit(exercice_comptable_id: $this->model->id, start_at: $start_at, end_at: $end_at);

                $type_solde_compte = (($account->balance ? $account->balance->solde : 0) + $mouv_debiteur) > $mouv_crediteur ? "debiteur" : "crediteur";

                $accountArrayData = [
                    "account_number" => $account->account_number,
                    "type_solde_compte" => $type_solde_compte,
                    "solde" =>  $type_solde_compte === "debiteur" ? $solde_debiteur : $solde_crediteur,
                    "date_report" => \Carbon\Carbon::now(),
                    "date_cloture" => \Carbon\Carbon::now()
                ];

                $account->close_balance()->create(array_merge($accountArrayData, ["exercice_comptable_id" => $this->model->id]));

                //$this->model->close_balance()->create(array_merge($accountArrayData, ["balanceable_id" => $account->id, "balanceable_type" => $account::class]));

            }
            
            if ($account->sous_comptes) {
                $this->clotureDesSousComptes(accounts: $account->sous_comptes, start_at: $start_at, end_at: $end_at);
            }
        }

        $cloture_at = isset($data["cloture_at"]) ? $data["cloture_at"] : now()->format("d/m/Y");

        return $this->model->update(["date_fermeture" => \Carbon\Carbon::createFromFormat("d/m/Y", $cloture_at), "status_exercice" => StatusExerciceEnum::CLOSE]);

    }

    /**
     * Report de solde aux sous-comptes et aux comptes de sub-divisions
     * 
     * @return void
     */
    private function clotureDesSousComptes(Collection $accounts, string $start_at, string $end_at): void
    {
        foreach ($accounts as $key => $account) {
            
            if(!$account->close_balance()->where("exercice_comptable_id", $this->model->id)->first()){

                $solde_debiteur = $account->balanceDeCompte(type: "debiteur", exercice_comptable_id: $this->model->id, start_at: $start_at, end_at: $end_at);
                $solde_crediteur = $account->balanceDeCompte(type: "crediteur", exercice_comptable_id: $this->model->id, start_at: $start_at, end_at: $end_at);

                $mouv_debiteur = $account->mouvementDebit(exercice_comptable_id: $this->model->id, start_at: $start_at, end_at: $end_at);
                $mouv_crediteur = $account->mouvementCredit(exercice_comptable_id: $this->model->id, start_at: $start_at, end_at: $end_at);

                $type_solde_compte = (($account->balance ? $account->balance->solde : 0) + $mouv_debiteur) > $mouv_crediteur ? "debiteur" : "crediteur";

                $accountArrayData = [
                    "account_number" => $account->account_number,
                    "type_solde_compte" => $type_solde_compte,
                    "solde" =>  $type_solde_compte === "debiteur" ? $solde_debiteur : $solde_crediteur,
                    "date_report" => \Carbon\Carbon::now(),
                    "date_cloture" => \Carbon\Carbon::now()
                ];

                $account->close_balance()->create(array_merge($accountArrayData, ["exercice_comptable_id" => $this->model->id]));
            }
            
            if ($account->sub_divisions) {
                $this->clotureDesSousComptes(accounts: $account->sub_divisions, start_at: $start_at, end_at: $end_at);
            }
        }
    }
}
