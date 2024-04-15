<?php

declare(strict_types=1);

namespace Domains\Finances\OperationsDisponible\Repositories;

use App\Models\Finances\ExerciceComptable;
use App\Models\Finances\OperationComptableDisponible;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Enums\StatusOperationDisponibleEnum;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\EcrituresComptable\DataTransfertObjects\CreateEcritureComptableDTO;
use Domains\Finances\EcrituresComptable\Repositories\EcritureComptableReadWriteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * ***`OperationDisponibleReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the OperationDisponible $instance data.
 *
 * @package ***`Domains\Finances\OperationsDisponible\Repositories`***
 */
class OperationDisponibleReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new OperationDisponibleReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\OperationComptableDisponible $model
     * @return void
     */
    public function __construct(OperationComptableDisponible $model)
    {
        parent::__construct($model);
    }


    /**
     * Operation comptable
     * 
     * @param array $data
     * 
     * @return Model
     */
    public function create(array $data): Model
    {
        DB::beginTransaction();
        try {

            $exerciceComptable = ExerciceComptable::findOrfail($data["exercice_comptable_id"]);

            $this->model = parent::create(array_merge($data, ["exercice_comptable_id" => $exerciceComptable->id]));

            foreach ($data["lignes_ecriture"] as $key => $ligne_ecriture) {
                $account = $exerciceComptable->plan_comptable->findAccountOrSubAccount(accountNumber: $ligne_ecriture["account_number"], columns: ["id", "account_number"]);

                if (!$account) throw new ModelNotFoundException("Compte inconnu : {$ligne_ecriture['account_number']}.", 1);

                $ligne = [
                    "type_ecriture_compte"  => $ligne_ecriture["type_ecriture_compte"],
                    "montant" => $ligne_ecriture["montant"],
                    'accountable_id' => $account->id,
                    'accountable_type' => $account::class,
                ];

                $ligne = $this->model->lignes_ecriture()->create($ligne);
            }

            $results = $this->model->lignes_ecriture()->getQuery()
                ->select('type_ecriture_compte', DB::raw('SUM(montant) as total'))
                ->groupBy('type_ecriture_compte')->get();

            $total = [];

            foreach ($results as $result) {
                if ($result->type_ecriture_compte->value === 'credit') {
                    $total["total_credit"] = $result->total;
                } elseif ($result->type_ecriture_compte->value === 'debit') {
                    $total["total_debit"] = $result->total;
                }
            }

            $this->model->update($total);

            DB::commit();

            return $this->model->refresh();
        } catch (CoreException $exception) {
            DB::rollBack();
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while registering ecriture comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }


    /**
     * Update une operation comptable
     * 
     * @param array $id
     * @param array $data
     * 
     * @return Model
     */
    public function update($id, array $data)
    {

        try {

            $this->model = $this->find($id);
            
            foreach ($data["lignes_ecriture"] as $key => $ligne_ecriture) {

                if (isset($ligne_ecriture["id"])) {
                    $ligne = $this->model->lignes_ecriture()->where("id", $ligne_ecriture["id"])->first();
                } else $ligne = null;

                $account = $this->model->exercice_comptable->plan_comptable->findAccountOrSubAccount(accountNumber: $ligne_ecriture["account_number"], columns: ["id", "account_number"]);

                if (!$account) throw new ModelNotFoundException("Compte inconnu : {$ligne_ecriture['account_number']}.", 1);

                $ligne_data = [
                    "type_ecriture_compte"  => $ligne_ecriture["type_ecriture_compte"],
                    "montant" => $ligne_ecriture["montant"],
                    'accountable_id' => $account->id,
                    'accountable_type' => $account::class,
                ];

                if (!$ligne) {
                    $this->model->lignes_ecriture()->create($ligne_data);
                } else {
                    $ligne->update($ligne_data);
                }
            }

            $results = $this->model->lignes_ecriture()->getQuery()
                ->select('type_ecriture_compte', DB::raw('SUM(montant) as total'))
                ->groupBy('type_ecriture_compte')->get();

            $total = [];

            foreach ($results as $result) {
                if ($result->type_ecriture_compte->value === 'credit') {
                    $total["total_credit"] = $result->total;
                } elseif ($result->type_ecriture_compte->value === 'debit') {
                    $total["total_debit"] = $result->total;
                }
            }

            $this->model->update($total);

            return $this->model->refresh();
        } catch (CoreException $exception) {
            // Throw a RepositoryException if there is an issue with the repository operation
            throw new RepositoryException(message: "Error while updating accounts in a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Valider une operation comptable
     *
     *
     * @param   string                                      $planComptableId        The unique identifier of the Plan Comptable to delete accounts from.
     *
     * @return  mixed                                                                Whether the accounts were deleted successfully.
     *
     * @throws  \Core\Utils\Exceptions\QueryException                               If there is an error while deleting accounts.
     * @throws  \Core\Utils\Exceptions\RepositoryException                          If there is an issue with the repository operation.
     */
    public function validateOperationComptable(string $operationComptableId, array $data): mixed
    {
        try {

            $this->model = $this->update(id: $operationComptableId, data: $data);

            $ecriture_data = CreateEcritureComptableDTO::fromModel($this->model)->toArray();

            $ecriture_data = array_merge($ecriture_data, ["exercice_comptable_id" => $this->model->exercice_comptable->id, "operation_disponible_id" => $this->model->id]);

            $ecriture_comptable = app(EcritureComptableReadWriteRepository::class)->create($ecriture_data);

            // Update the Excercice Comptable by ID
            $this->model->update(["status_operation" => StatusOperationDisponibleEnum::VALIDER]);

            return $this->model->fresh();
        } catch (CoreException $exception) {
            // Throw a RepositoryException if there is an issue with the repository operation
            throw new RepositoryException(message: "Error while updating accounts in a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
