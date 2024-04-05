<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\Repositories;

use App\Models\Finances\EcritureComptable;
use App\Models\Finances\ExerciceComptable;
use App\Models\Finances\ExerciceComptableJournal;
use App\Models\Finances\LigneEcritureComptable;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * ***`EcritureComptableReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the EcritureComptable $instance data.
 *
 * @package ***`Domains\Finances\EcrituresComptable\Repositories`***
 */
class EcritureComptableReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * @var LigneEcritureComptable
     */
    protected $ligneEcritureComptable;

    /**
     * Create a new EcritureComptableReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\EcritureComptable $model
     * @return void
     */
    public function __construct(EcritureComptable $model, LigneEcritureComptable $ligneEcritureComptable)
    {
        parent::__construct($model);
        $this->ligneEcritureComptable = $ligneEcritureComptable;
    }

    public function create(array $data): Model
    {
        DB::beginTransaction();
        try {

            $exerciceComptable = ExerciceComptable::findOrfail($data["exercice_comptable_id"]);

            $this->model = parent::create(array_merge($data, ["exercice_comptable_journal_id" => $this->retrieveExerciceComptable($exerciceComptable, $data["journal_id"])->id]));

            foreach ($data["lignes_ecriture"] as $key => $ligne_ecriture) {
                $account = $exerciceComptable->plan_comptable->findAccountOrSubAccount(accountNumber: $ligne_ecriture["account_number"], columns: ["id", "account_number"]);

                if (!$account) throw new ModelNotFoundException("Compte inconnu : {$ligne_ecriture['account_number']}.", 1);

                $ligne = [
                    "type_ecriture_compte"  => $ligne_ecriture["type_ecriture_compte"],
                    "montant" => $ligne_ecriture["montant"],
                    'accountable_id' => $account->id,
                    'accountable_type' => $account::class,
                ];

                $this->model->lignes_ecriture()->create($ligne);
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

    private function retrieveExerciceComptable($exerciceComptable, string $journalId)
    {
        if (!($exerciceComptableJournal = $exerciceComptable->journaux()->where("journal_id", $journalId)->first())) {
            $exerciceComptableJournal = ExerciceComptableJournal::create(["exercice_comptable_id" => $exerciceComptable->id, "journal_id" => $journalId]);
        }

        return $exerciceComptableJournal;
    }

    private function hasCompteIdInSubDivisions($subDivisions, $compteId)
    {
        foreach ($subDivisions as $subDivision) {
            if ($subDivision->sous_compte_id == $compteId) {
                return true;
            }

            if ($subDivision->sub_divisions->isNotEmpty() && $this->hasCompteIdInSubDivisions($subDivision->sub_divisions, $compteId)) {
                return true;
            }
        }

        return false;
    }
}
