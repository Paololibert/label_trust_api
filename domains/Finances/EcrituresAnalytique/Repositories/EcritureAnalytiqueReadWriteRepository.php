<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresAnalytique\Repositories;

use App\Models\Finances\ExerciceComptable;
use App\Models\Finances\EcritureAnalytique;
use App\Models\Finances\ExerciceComptableJournal;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * ***`EcritureAnalytiqueReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the EcritureAnalytique $instance data.
 *
 * @package ***`Domains\Finances\EcrituresAnalytique\Repositories`***
 */
class EcritureAnalytiqueReadWriteRepository extends EloquentReadWriteRepository
{

    /**
     * Create a new EcritureAnalytiqueReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\EcritureAnalytique $model
     * @return void
     */
    public function __construct(EcritureAnalytique $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): Model
    {
        DB::beginTransaction();
        try {

            $exerciceComptable = ExerciceComptable::findOrfail($data["exercice_comptable_id"]);

            $account = $exerciceComptable->plan_comptable->findAccountOrSubAccount(accountNumber: $data["account_number"], columns: ["id", "account_number"]);

            $this->model = parent::create(array_merge($data, [
                'accountable_id' => $account->id,
                'accountable_type' => $account::class,
                "exercice_comptable_journal_id" => $this->retrieveExerciceComptable($exerciceComptable, $data["journal_id"])->id
            ]));
            
            DB::commit();

            return $this->model->refresh();

        } catch (CoreException $exception) {
            DB::rollBack();
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while registering ecriture comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    private function retrieveExerciceComptable($exerciceComptable, string $journalId)
    {
        if (!($exerciceComptableJournal = $exerciceComptable->journaux()->where("journal_id", $journalId)->first())) {
            $exerciceComptableJournal = ExerciceComptableJournal::create(["exercice_comptable_id" => $exerciceComptable->id, "journal_id" => $journalId]);
        }

        return $exerciceComptableJournal;
    }
}
