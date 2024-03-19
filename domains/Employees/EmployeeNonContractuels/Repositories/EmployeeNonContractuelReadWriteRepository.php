<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\Repositories;

use App\Models\EmployeeNonContractuel;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use App\Models\CategoryOfEmployee;
use Exception;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\Repositories\CategoryOfEmployeeTauxReadWriteRepository;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;
use Throwable;
/**
 * ***`EmployeeNonContractuelReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the EmployeeNonContractuel $instance data.
 *
 * @package ***`Domains\Employees\EmployeeNonContractuels\Repositories`***
 */
class EmployeeNonContractuelReadWriteRepository extends EloquentReadWriteRepository
{
    private $categoryOfEmployeeTauxReadWriteRepository;

    /**
     * Create a new EmployeeNonContractuelReadWriteRepository instance.
     *
     * @param  \App\Models\EmployeeNonContractuel $model
     * 
     * 
     * @return void
     */
    public function __construct(EmployeeNonContractuel $model, CategoryOfEmployeeTauxReadWriteRepository $categoryOfEmployeeTauxReadWriteRepository)
    {
        parent::__construct($model);
        $this->categoryOfEmployeeTauxReadWriteRepository = $categoryOfEmployeeTauxReadWriteRepository;
    }


    /**
     * Change the category of a non-contractual employee.
     *
     * @param string            $employeeId The ID of the non-contractual employee.
     * @param string            $newCategoryId The ID of the new category.
     * @param array             $data Additional data such as 'date_debut', 'category_of_employee_taux_id'.
     *
     * @return bool             True if the category is successfully changed, false otherwise.
     * @throws Exception        If the employee or the category is not found.
     */
    public function changeCategoryOfNonContractualEmployee(string $employeeId, string $newCategoryId, array $data): bool
    {
        try {

            // Find the non-contractual employee by ID
            $employee = $this->model->find($employeeId);
    
            // Get the ID of the current category
            $currentCategoryId = $employee->categories()->wherePivot('date_fin', null)->wherePivot('category_of_employee_id', $data['category_of_employee_id'])->first();

            if(!$currentCategoryId) throw new Exception("Impossible to get the current categorie of the employee.");
    
            // Check if the new category exists
               $emp_Cont_rep = $this->categoryOfEmployeeTauxReadWriteRepository->find($newCategoryId);

            //CategoryOfEmployee::findOrFail($newCategoryId);

            
            // Update the end date of the current category
            if ($currentCategoryId) {
                DB::table('employee_non_contractuel_categories')
                    ->where('employee_non_contractuel_id', $employeeId)
                    ->where('category_of_employee_id', $currentCategoryId->id)
                    ->update(['date_fin' => now()]);
            }
    
            $categoryEmployeeTauxId = $data['category_of_employee_taux_id'] ?? null;

            $attributes = [
                
                'date_debut' => $data['date_debut'],

                'category_of_employee_taux_id' =>$categoryEmployeeTauxId
            ];

            // Attach the new category to the employee with the provided data

            $employee->categories()->attach($newCategoryId, $attributes);
            
            return true;
            
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }

}