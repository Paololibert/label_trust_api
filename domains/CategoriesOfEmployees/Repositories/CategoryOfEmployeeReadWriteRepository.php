<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\Repositories;

use App\Models\CategoryOfEmployee;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Throwable;

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
            
        } catch (ModelNotFoundException $exception) {
            throw new QueryException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while attaching taux to category of employee.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while attaching taux to category of employee.", previous: $exception);
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
        } catch (ModelNotFoundException $exception) {
            throw new QueryException(message: "{$exception->getMessage()}", previous: $exception);
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while detaching taux from category of employee.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while detaching taux from category of employee.", previous: $exception);
        }
    }
    
    /**
     * Check if the specified relationship exists for the given IDs.
     *
     * @param \Illuminate\Database\Eloquent\Relations\BelongsToMany $relation
     * @param array $ids
     *
     * @return bool
     */
    protected function relationExists(BelongsToMany $relation, array $ids): bool
    {
        return $relation->wherePivotIn('id', $ids)->exists();
    }
}