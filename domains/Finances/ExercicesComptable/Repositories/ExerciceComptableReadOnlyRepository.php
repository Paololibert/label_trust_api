<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\Repositories;

use App\Http\Resources\Finances\BalanceDesComptesResource;
use App\Http\Resources\Finances\JournauxResource;
use App\Models\Finances\ExerciceComptable;
use Core\Data\Repositories\Eloquent\EloquentReadOnlyRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;
use Illuminate\Support\Facades\DB;

/**
 * ***`ExerciceComptableReadOnlyRepository`***
 *
 * This class extends the EloquentReadOnlyRepository class, which suggests that it is responsible for providing read-only access to the ExerciceComptable $instance data.
 *
 * @package ***`\Domains\Finances\ExercicesComptable\Repositories`***
 */
class ExerciceComptableReadOnlyRepository extends EloquentReadOnlyRepository
{
    /**
     * Create a new ExerciceComptableReadOnlyRepository instance.
     *
     * @param  \App\Models\Finances\ExerciceComptable $model
     * @return void
     */
    public function __construct(ExerciceComptable $model)
    {
        parent::__construct($model);
    }

    public function balanceDesComptes(string $exerciceComptableId, array $periodeArrayData)
    {
        try {

            /* $accounts_balance = $this->find($exerciceComptableId)->load([
                "plan_comptable.accounts.transactions" => function ($q) use ($exerciceComptableId) {
                $q
                    ->select("type_ecriture_compte", DB::raw('SUM(montant) as total')) // Specify the columns you want to select
                    ->where("ligneable_type", "App\Models\Finances\EcritureComptable")
                    ->whereHas("ligneable.exercice_comptable_journal", function ($ligne_query) use ($exerciceComptableId) {
                        $ligne_query->where("exercice_comptable_id", $exerciceComptableId);
                    })->groupBy('type_ecriture_compte'); // Include the id column in the GROUP BY clause
            }, "plan_comptable.accounts.balance" => function ($query) use ($exerciceComptableId) {
                $query->where("exercice_comptable_id", $exerciceComptableId);
            }]); */

            /*$accounts_balance = ExerciceComptable::query()->with(["plan_comptable.accounts" => function($query) use ($exerciceComptableId) {
                $query->soldeDesComptes($exerciceComptableId)->transactions($exerciceComptableId);
            }])->where("id", $exerciceComptableId)->first();*/

            $accounts_balance = $this->find($exerciceComptableId);

            return new BalanceDesComptesResource(resource: $accounts_balance, start_at: isset($periodeArrayData["from_date"]) ? $periodeArrayData["from_date"] : null, end_at: isset($periodeArrayData["to_date"]) ? $periodeArrayData["to_date"] : null);
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while quering balance of accounts of an exercice comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    public function balanceDeCompte(string $exerciceComptableId, array $data)
    {
        try {
            $exercice_comptable = $this->find($exerciceComptableId);
            
            $account = $exercice_comptable->plan_comptable->findAccountOrSubAccount($data["account_number"]);


            return new BalanceDesComptesResource(resource: $exercice_comptable);
            
            /* 
            return [
                "id"                            => $exercice_comptable->id,
                "fiscal_year"                   => $exercice_comptable->fiscal_year,
                "date_ouverture"                => $exercice_comptable->date_ouverture->format("Y-m-d"),
                "date_fermeture"                => $exercice_comptable->date_fermeture,
                "status_exercice"               => $exercice_comptable->status_exercice,
                "accounts"                      => [
                        'id'                    => $account->id,
                        'intitule'              => $account->intitule,
                        "classe_de_compte"      => $account->classe_de_compte,
                        "categorie_de_compte"   => $account->categorie_de_compte,
                        'account_number'        => $account->account_number,
                        "solde_debiteur"        => $this->solde($account, "debit"),
                        "solde_crediteur"       => $this->solde($account, "credit"),
                        "mouvement_debit"       => $this->mouvements_debit($account),
                        "mouvement_credit"      => $this->mouvements_credit($account),
                        "sub_accounts"          => $this->sub_accounts($account->sous_comptes),
                        'created_at'            => $account->created_at->format("Y-m-d")
                ],
                "created_at"                    => $this->created_at->format("Y-m-d")
            ]; */
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while quering balance of accounts of an exercice comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    public function journaux(string $exerciceComptableId, array $periodeArrayData)
    {
        try {
            $exercice_comptable = $this->find($exerciceComptableId)->load(["journaux", "journaux.ecritures_comptable"]);

            return new JournauxResource(resource: $exercice_comptable);
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while quering balance of accounts of an exercice comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    public function journal(string $exerciceComptableId, string $journalId, array $periodeArrayData)
    {
        try {
            $exercice_comptable = $this->find($exerciceComptableId)->load(["journaux"=> function($query) use($journalId) {
                $query->where("id", $journalId)->wherePivot("journal_id", $journalId)->with("ecritures_comptable");
            }]);

            return new JournauxResource(resource: $exercice_comptable);
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while quering balance of accounts of an exercice comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
