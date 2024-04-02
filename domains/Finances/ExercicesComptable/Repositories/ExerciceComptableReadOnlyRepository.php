<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\Repositories;

use App\Http\Resources\ExerciceComptableResource;
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
            $this->model = $this->find($exerciceComptableId);

            /*$this->model = $this->model->load([
                "plan_comptable.accounts.balance"
                /* , "ecritures_comptable" => function ($query) use ($periodeArrayData) {
                    $query->whereBetween('date_ecriture', [$periodeArrayData["from_date"], $periodeArrayData["to_date"]]);
                } /
            ]);*/

            $this->model = $this->model->load([
                'plan_comptable.accounts.balance' => function ($query) use ($periodeArrayData) {
                    $query->select('id', 'solde_credit', 'solde_debit')
                        ->withCount(['ecritures_comptable as sum_solde_credit' => function ($query) use ($periodeArrayData) {
                            $query->select(DB::raw('IFNULL(SUM(solde_credit), 0)'))
                                ->whereBetween('date_ecriture', [$periodeArrayData]);
                        }])
                        ->withCount(['ecritures_comptable as sum_solde_debit' => function ($query) use ($periodeArrayData) {
                            $query->select(DB::raw('IFNULL(SUM(solde_debit), 0)'))
                                ->whereBetween('date_ecriture', [$periodeArrayData]);
                        }])
                        ->get()
                        ->each(function ($balance) {
                            $balance->solde_credit -= $balance->sum_solde_credit;
                            $balance->solde_debit -= $balance->sum_solde_debit;
                        });
                }
            ]);

            return new ExerciceComptableResource($this->model);
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while quering balance of accounts of an exercice comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
