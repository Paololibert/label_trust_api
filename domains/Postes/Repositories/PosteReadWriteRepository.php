<?php

declare(strict_types=1);

namespace Domains\Postes\Repositories;

use App\Models\Poste;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;

/**
 * ***`PosteReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Poste $instance data.
 *
 * @package ***`Domains\Postes\Repositories`***
 */
class PosteReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new PosteReadWriteRepository instance.
     *
     * @param  \App\Models\Poste $model
     * @return void
     */
    public function __construct(Poste $model)
    {
        parent::__construct($model);
    }

    /**
     * Attach salaries to a poste.
     *
     * This method associates specific salaries with a given poste.
     *
     * @param   string      $posteId        The unique identifier of the poste.
     * @param   array       $salariesIds    The array of access identifiers representing the salaries to be attached.
     *
     * @return  bool                        Whether the salaries were attached successfully.
     */
    public function attachSalaries(string $posteId, $salariesIds): bool
    {
        try {

            $this->model = $this->find($posteId);

            foreach ($salariesIds as $key => $salary) {
                if(isset($salary['salary_id'])){
                    // Check if the salary is not already attached
                    if (!$this->relationExists($this->model->salaries(), [$salary['salary_id']])) {
                        // Attach the salary
                        return $this->model->salaries()->syncWithoutDetaching($salary['salary_id'], $salary) ? true : false;
                    }
                }
            }
    
            return false; // Taux is already attached
            
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while attaching salaries to poste." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }      
    }

    /**
     * Detach salary from a poste.
     *
     * This method associates specific taux with a given poste.
     *
     * @param   string      $posteId       The unique identifier of the poste.
     * @param   array       $salariesIds   The array of access identifiers representing the taux to be detached.
     *
     * @return  bool                       Whether the taux were detached successfully.
     */
    public function detachSalaries(string $posteId, $salariesIds): bool
    {
        try {

            $this->model = $this->find($posteId);

            $this->model->salaries()->updateExistingPivot($salariesIds, ['deleted_at' => now()]);
            $this->model->refresh();
            dd($this->model->salaries);

            return $this->model->salaries()->updateExistingPivot($salariesIds, ['deleted_at' => now()]) ? true : false;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: "Error while detaching salaries from poste." . $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }  
}