<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\Repositories;

use App\Http\Resources\BalanceDesComptesResource;
use App\Http\Resources\ExerciceComptableResource;
use App\Http\Resources\JournauxResource;
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

            $accounts_balance = $this->find($exerciceComptableId)->load("plan_comptable");

            return new BalanceDesComptesResource(resource: $accounts_balance);
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while quering balance of accounts of an exercice comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    public function balanceDeCompte(string $exerciceComptableId, string $compteId, array $periodeArrayData)
    {
        try {

            $exercice_comptable = $this->find($exerciceComptableId)->load(["plan_comptable" => function($query) use($compteId){
                $query->with(["accounts", function($query) use($compteId){
                    $query->where("compte_id", $compteId);
                }]);
            }]);

            return new BalanceDesComptesResource(resource: $exercice_comptable);
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
