<?php

declare(strict_types=1);

namespace Domains\UniteTravailles\Repositories;

use App\Models\UniteTravaille;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Montants\Repositories\MontantReadWriteRepository;
use Domains\TauxAndSalaries\Repositories\TauxAndSalaryReadWriteRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

/**
 * ***`UniteTravailleReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the UniteTravaille $instance data.
 *
 * @package ***`Domains\UniteTravailles\Repositories`***
 */
class UniteTravailleReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * @var MontantReadWriteRepository
     */
    private $montantRepository;

    /**
     * @var TauxAndSalaryReadWriteRepository
     */
    private $tauxRepository;

    /**
     * Create a new UniteTravailleReadWriteRepository instance.
     *
     * @param UniteTravaille                    $model
     * @param MontantReadWriteRepository        $montantRepository
     * @param TauxAndSalaryReadWriteRepository  $tauxRepository
     */
    public function __construct(UniteTravaille $model, MontantReadWriteRepository $montantRepository, TauxAndSalaryReadWriteRepository $tauxRepository)
    {
        parent::__construct($model);
        $this->montantRepository = $montantRepository;
        $this->tauxRepository = $tauxRepository;
    }

    /**
     * Create a new record.
     *
     * @param   array               $data   The data for creating the record.
     * @return  UniteTravaille              The created record.
     *
     * @throws  RepositoryException         If there is an error while creating the record.
     */
    public function create(array $data): UniteTravaille
    {
        try {
            $this->model = parent::create($data);

            // Perform create operation
            $this->createTaux($this->model->id, $data['taux']);

            return $this->model->refresh();
        } catch (QueryException $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }

    /**
     * Create taux for unite travailles.
     *
     * @param string            $uniteTravailleId
     * @param array             $tauxDataArray
     * @return bool
     * @throws QueryException
     */
    public function createTaux(string $uniteTravailleId, array $tauxDataArray): bool
    {
        try {
            $this->model = $this->find($uniteTravailleId);

            // Iterate through each taux data in the array
            foreach ($tauxDataArray as $tauxData) {

                // Check if the associated montant exists, and create if it doesn't
                $montant = $this->checkAndCreateMontant($tauxData['rate']);

                // Check if the taux relationship exists, and sync if it doesn't
                if (!$this->model->taux()->where(function ($query) use ($montant, $tauxData) {
                    $query->where('montant_id', $montant->id)
                        ->where('hint', $tauxData['hint'])
                        ->where('unite_mesure_id', $tauxData['unite_mesure_id']);
                })->exists()) {
                    $this->model->montants()->attach([$montant->id => $tauxData]);
                }
            }

            return true;
        } catch (ModelNotFoundException $exception) {
            throw new QueryException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while creating taux for unite travaille.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating taux for unite travaille.", previous: $exception);
        }
    }

    /**
     * Edit taux for unite travailles.
     *
     * @param string $uniteTravailleId
     * @param array $tauxData
     * @return bool
     * @throws QueryException
     */
    public function editTaux(string $uniteTravailleId, array $tauxData): bool
    {
        try {
            $this->model = $this->find($uniteTravailleId);

            // Iterate through each tauxData and update the corresponding taux
            foreach ($tauxData as $editedTaux) {
                // Find the corresponding TauxAndSalary model by ID
                $tauxModel = $this->model->taux()->find($editedTaux['taux_id']);

                // Check if the taux model exists and update if it does
                if ($tauxModel) {
                    // Check if the rate has changed
                    if (isset($editedTaux['rate']) && $tauxModel->montant->montant != $editedTaux['rate']) {
                        // Rate has changed, perform create operation

                        $montant = $this->checkAndCreateMontant($editedTaux['rate']);

                        $tauxModel->update(array_merge($editedTaux, ['montant_id' => $montant->id]));
                        
                    } else {
                        // Rate hasn't changed, update the existing taux
                        $tauxModel->update($editedTaux);
                    }
                    $tauxModel->update($editedTaux);
                } else {
                    throw new QueryException("Taux with ID {$editedTaux['taux_id']} not found for editing.");
                }
            }

            return true;
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while editing taux for unite travaille.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while editing taux for unite travaille.", previous: $exception);
        }
    }

    /**
     * Remove taux from unite travailles.
     *
     * @param   string          $uniteTravailleId
     * @param   array           $tauxIds
     * @return  bool
     * @throws  QueryException
     */
    public function removeTaux(string $uniteTravailleId, array $tauxIds): bool
    {
        try {
            $this->model = $this->find($uniteTravailleId);

            // Detach taux with the given IDs from the unite travaille
            return $this->model->taux()->whereIn("id", $tauxIds)->delete() ? true : false;
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while removing taux from unite travaille.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while removing taux from unite travaille.", previous: $exception);
        }
    }

    /**
     * Check if the associated montant exists, and create if it doesn't.
     *
     * @param float $rate The rate to check and create if necessary.
     * @return \App\Models\Montant The associated Montant model.
     * @throws \Core\Utils\Exceptions\QueryException If there is an error while creating the Montant model.
     */
    private function checkAndCreateMontant(float $rate): \App\Models\Montant
    {
        try {
            // Check if the associated montant exists
            $montant = $this->montantRepository->first(['montant' => $rate]);

            // Create a new montant if it doesn't exist
            if (!$montant) {
                $montant = $this->montantRepository->create(['montant' => $rate]);
            }

            return $montant;
        } catch (\Throwable $exception) {
            // Handle any exceptions that may occur during the process
            throw new QueryException(message: 'Error while checking and creating Montant.', previous: $exception);
        }
    }
}