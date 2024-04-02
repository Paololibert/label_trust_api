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

            $this->model->lignes_ecriture()->create(array_map(function ($ligne_ecriture) use ($exerciceComptable) {

                //dd($exerciceComptable->plan_comptable->accounts);

                if (!($account = $exerciceComptable->accounts()->where("compte_id", $ligne_ecriture["compte_id"])->first())) {
                    $account = $exerciceComptable->plan_comptable->accounts()
                        ->where(function ($query) use ($ligne_ecriture) {
                            $query->where("compte_id", $ligne_ecriture["compte_id"])
                                ->orWhereHas('sous_comptes', function ($query) use ($ligne_ecriture) {
                                    $query->where("sous_compte_id", $ligne_ecriture["compte_id"]);
                                });
                        })->get();
                    $exerciceComptable->accounts()->where("plan_comptable_id", $exerciceComptable->plan_comptable_id)->where("compte_id", $ligne_ecriture["compte_id"])->first();
                }

                $account = $exerciceComptable->plan_comptable->accounts()
                    ->where(function ($query) use ($ligne_ecriture) {
                        $query->where("compte_id", $ligne_ecriture["compte_id"])
                            ->orWhereHas('sous_comptes', function ($query) use ($ligne_ecriture) {
                                $query->where("sous_compte_id", $ligne_ecriture["compte_id"]);
                            });
                    })
                    ->orWhereHas('sub_divisions', function ($query) use ($ligne_ecriture) {
                        $query->where("sous_compte_id", $ligne_ecriture["compte_id"]);
                    })
                    ->first();


                dd($account);

                $account = $exerciceComptable->plan_comptable->accounts()
                    ->where(function ($query) use ($ligne_ecriture) {
                        $query->where("compte_id", $ligne_ecriture["compte_id"])
                            ->orWhereHas('sous_comptes', function ($query) use ($ligne_ecriture) {
                                $query->where("sous_compte_id", $ligne_ecriture["compte_id"])
                                    ->orWhereHas('sub_divisions', function ($query) use ($ligne_ecriture) {
                                        $query->where("sous_compte_id", $ligne_ecriture["compte_id"]);
                                    });
                            });
                    })/* ->get()
                    ->filter(function ($account) use ($ligne_ecriture) {
                        dd($account);
                        return $this->hasCompteIdInSubDivisions($account->sub_divisions, $ligne_ecriture["compte_id"]);
                    }) */->first();
                /* ->where(function ($query) use ($ligne_ecriture) {
                        $query->where("compte_id", $ligne_ecriture["compte_id"])
                            ->orWhereHas('sub_accounts', function ($query) use ($ligne_ecriture) {
                                $query->where("compte_id", $ligne_ecriture["compte_id"]);
                            });
                    }); */

                dd($account);

                if (!($account = $exerciceComptable->accounts()->where("compte_id", $ligne_ecriture["compte_id"])->first())) {
                    $exerciceComptable->accounts()->where("plan_comptable_id", $exerciceComptable->plan_comptable_id)->where("compte_id", $ligne_ecriture["compte_id"])->first();
                }
                dd($account);

                return [

                    "type_ecriture_compte"  => $ligne_ecriture["type_ecriture_compte"],
                    "montant" => $ligne_ecriture["montant"],
                    'accountable_id' => $ligne_ecriture["montant"],
                    'accountable_type' => $ligne_ecriture["montant"],
                ];
            }, $data["lignes_ecriture"]));

            dd($this->model);

            return $this->model->refresh();
        } catch (CoreException $exception) {
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
