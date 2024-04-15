<?php

declare(strict_types=1);

namespace Domains\Finances\OperationsAnalytique\Repositories;

use App\Models\Finances\ExerciceComptable;
use App\Models\Finances\OperationComptableDisponible;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Enums\StatusOperationDisponibleEnum;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\EcrituresAnalytique\DataTransfertObjects\CreateEcritureAnalytiqueDTO;
use Domains\Finances\EcrituresAnalytique\Repositories\EcritureAnalytiqueReadWriteRepository;
use Domains\Finances\EcrituresComptable\DataTransfertObjects\CreateEcritureComptableDTO;
use Domains\Finances\EcrituresComptable\Repositories\EcritureComptableReadWriteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * ***`OperationAnalytiqueReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the OperationAnalytique $instance data.
 *
 * @package ***`Domains\Finances\OperationsAnalytique\Repositories`***
 */
class OperationAnalytiqueReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new OperationAnalytiqueReadWriteRepository instance.
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

            $account = $exerciceComptable->plan_comptable->findAccountOrSubAccount(accountNumber: $data["account_number"], columns: ["id", "account_number"]);

            $this->model = parent::create(array_merge($data, [
                'accountable_id' => $account->id,
                'accountable_type' => $account::class
            ]));

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
            
            $exerciceComptable = ExerciceComptable::findOrfail($data["exercice_comptable_id"]);

            $account = $exerciceComptable->plan_comptable->findAccountOrSubAccount(accountNumber: $data["account_number"], columns: ["id", "account_number"]);

            $this->model = parent::update($this->model->id, array_merge($data, [
                'accountable_id' => $account->id,
                'accountable_type' => $account::class
            ]));

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
     * @param   string                                      $operationAnalytiqueId  The unique identifier of the operation
     *
     * @return  mixed                                                              
     *
     * @throws  \Core\Utils\Exceptions\QueryException                               
     * @throws  \Core\Utils\Exceptions\RepositoryException                          
     */
    public function validateOperationAnalytique(string $operationAnalytiqueId, array $data): mixed
    {
        try {

            $this->model = $this->update(id: $operationAnalytiqueId, data: $data);

            $ecriture_data = CreateEcritureAnalytiqueDTO::fromModel($this->model)->toArray();

            $ecriture_data = array_merge($ecriture_data, ["exercice_comptable_id" => $this->model->exercice_comptable->id, "operation_disponible_id" => $this->model->id]);

            $ecriture_comptable = app(EcritureAnalytiqueReadWriteRepository::class)->create($ecriture_data);

            // Update the Excercice Comptable by ID
            $this->model->update(["status_operation" => StatusOperationDisponibleEnum::VALIDER]);

            return $this->model->fresh();
        } catch (CoreException $exception) {
            // Throw a RepositoryException if there is an issue with the repository operation
            throw new RepositoryException(message: "Error while updating accounts in a plan comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
