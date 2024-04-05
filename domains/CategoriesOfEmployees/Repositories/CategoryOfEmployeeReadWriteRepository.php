<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\Repositories;

use App\Models\CategoryOfEmployee;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\Contract\CoreException;
use Core\Utils\Exceptions\RepositoryException;

/**
 * ***`CategoryOfEmployeeReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the CategoryOfEmployee $instance data.
 *
 * @package ***`Domains\CategoriesOfEmployees\Repositories`***
 */
class CategoryOfEmployeeReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * Create a new CategoryOfEmployeReadWriteRepository instance.
     *
     * @param  \App\Models\CategoryOfEmployee $model
     * @return void
     */
    public function __construct(CategoryOfEmployee $model)
    {
        parent::__construct($model);
    }

    /**
     * Attach taux to a category of employee.
     *
     * This method associates specific taux with a given category of employee.
     *
     * @param   string      $categoryEmployeeId     The unique identifier of the CategoryOfEmployee.
     * @param   array       $tauxIds                The array of access identifiers representing the taux to be attached.
     *
     * @return  bool                                Whether the taux were attached successfully.
     */
    public function attachTaux(string $categoryEmployeeId, $tauxIds): bool
    {
        try {

            $this->model = $this->find($categoryEmployeeId);

            foreach ($tauxIds as $key => $taux) {
                if(isset($taux['taux_id'])){
                    // Check if the taux is not already attached
                    if (!$this->relationExists($this->model->taux(), [$taux['taux_id']])) {
                        // Attach the taux
                        return $this->model->taux()->syncWithoutDetaching($taux['taux_id'], $taux) ? true : false;
                    }
                }else {
                    
                }
            }
    
            return false; // Taux is already attached
            
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message: $exception->getMessage(), status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }

    /**
     * Detach taux from a category of employee.
     *
     * This method associates specific taux with a given category of employee.
     *
     * @param   string      $categoryEmployeeId     The unique identifier of the category of employee.
     * @param   array       $tauxIds                The array of access identifiers representing the taux to be detached.
     *
     * @return  bool                                Whether the taux were detached successfully.
     */
    public function detachTaux(string $categoryEmployeeId, $tauxIds): bool
    {
        try {

            $this->model = $this->find($categoryEmployeeId);

            return $this->model->taux()->updateExistingPivot($tauxIds, ['deleted_at' => now()]) ? true : false;
        } catch (CoreException $exception) {
            // Throw a NotFoundException with an error message and the caught exception
            throw new RepositoryException(message:"{$exception->getMessage()}", status_code: $exception->getStatusCode(), error_code: $exception->getErrorCode(), code: $exception->getCode(), error: $exception->getError(), previous: $exception);
        }
    }
}