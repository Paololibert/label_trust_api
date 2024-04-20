<?php

declare(strict_types=1);

namespace Domains\Finances\Immobilisations\Repositories;

use App\Models\Finances\ExerciceComptable;
use App\Models\Finances\Immobilisation;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Finances\Immobilisations\Ammortissements\Repositories\AmmortissementReadWriteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * ***`ImmobilisationReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Immobilisation $instance data.
 *
 * @package ***`Domains\Finances\EcrituresComptable\Repositories`***
 */
class ImmobilisationReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * @var AmmortissementReadWriteRepository
     */
    protected AmmortissementReadWriteRepository $ammortissementReadWriteRepository;

    /**
     * Create a new ImmobilisationReadWriteRepository instance.
     *
     * @param  \App\Models\Finances\Immobilisation $model
     * @return void
     */
    public function __construct(Immobilisation $model, AmmortissementReadWriteRepository $ammortissementReadWriteRepository)
    {
        parent::__construct($model);
        $this->ammortissementReadWriteRepository = $ammortissementReadWriteRepository;
    }

    public function create(array $data): Model
    {
        DB::beginTransaction();
        try {

            $exerciceComptable = ExerciceComptable::findOrfail($data["exercice_comptable_id"]);

            $account = $exerciceComptable->plan_comptable->findAccountOrSubAccount(accountNumber: (string) $data["account_number"], columns: ["id", "account_number"]);

            $this->model = parent::create(array_merge($data, [
                'accountable_id' => $account->id,
                'accountable_type' => $account::class
            ]));

           $this->model->createAmmortissements();

            /* foreach ($data["lignes_ecriture"] as $key => $ligne_ecriture) {
                $account = $exerciceComptable->plan_comptable->findAccountOrSubAccount(accountNumber: $ligne_ecriture["account_number"], columns: ["id", "account_number"]);

                if (!$account) throw new ModelNotFoundException("Compte inconnu : {$ligne_ecriture['account_number']}.", 1);

                $ligne = [
                    "type_ecriture_compte"  => $ligne_ecriture["type_ecriture_compte"],
                    "montant" => $ligne_ecriture["montant"],
                    'accountable_id' => $account->id,
                    'accountable_type' => $account::class,
                ];

                $this->model->lignes_ecriture()->create($ligne);
            } */

            DB::commit();

            return $this->model->refresh();
        } catch (CoreException $exception) {
            DB::rollBack();
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while registering ecriture comptable." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}
