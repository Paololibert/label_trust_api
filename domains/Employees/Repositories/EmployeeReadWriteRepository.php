<?php

declare(strict_types=1);

namespace Domains\Employees\Repositories;

use App\Models\Employee;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Enums\TypeEmployeeEnum;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Contrats\Repositories\ContractReadWriteRepository;
use Domains\Employees\EmployeeContractuels\Repositories\EmployeeContractuelReadWriteRepository;
use Domains\Employees\EmployeeNonContractuels\Repositories\EmployeeNonContractuelReadWriteRepository;
use Domains\Users\Repositories\UserReadWriteRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * ***`EmployeeReadWriteRepository`***
 *
 * This class extends the EloquentReadWriteRepository class, which suggests that it is responsible for providing read-only access to the Employee $instance data.
 *
 * @package ***`Domains\Employees\Repositories`***
 */
class EmployeeReadWriteRepository extends EloquentReadWriteRepository
{
    /**
     * @var EmployeeContractuelReadWriteRepository 
     */
    private $employeeContRWRep;

    /**
     * @var EmployeeNonContractuelReadWriteRepository
     */
    private $employeeNCtrWRep;

    /**
     * @var UserReadWriteRepository
     */
    private $userReadWriteRepository;

    /**
     * @var ContractReadWriteRepository
     */
    private $contractReadW;
    /**
     * Create a new EmployeeReadWriteRepository instance.
     *
     * @param  \App\Models\Employee $model
     * @return void
     */
    public function __construct(Employee $model, EmployeeContractuelReadWriteRepository $employeeContRWRep,EmployeeNonContractuelReadWriteRepository $employeeNonContRWRep ,UserReadWriteRepository $userReadWriteRepository, ContractReadWriteRepository $contractRead)
    {
        parent::__construct($model);
        $this->employeeContRWRep = $employeeContRWRep;
        $this->employeeNCtrWRep = $employeeNonContRWRep; 
        $this->userReadWriteRepository = $userReadWriteRepository;
        $this->contractReadW = $contractRead;
        
    }
    
    
    /**
     * Create a new record.
     *
     * @param  array $data         The data for creating the record.
     * @return Employee               The created record.
     *
     * 
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while creating the record.
     */
    public function create(array $data): Employee
    {
        try {
            
            $theparent =  $this->model = parent::create($data);

            $employeDetail = null;


            if($data['type_employee'] === TypeEmployeeEnum::REGULIER->value)
            {
                $employeDetail = $this->employeeContRWRep->create($data['data']);

                $contract = $this->contractReadW->create(array_merge($data['data'], ['employee_contractuel_id' => $employeDetail->id]));

                if (!$contract) throw new Exception("Error occur while creating contract",1);

                if (!isset($data['data']['poste_salaire_id'])){
                    if (!$contract->salaires()->exists()) {
                        $salary = $contract->salaires()->create($data['data']);
                        
                    }
                }
                
            }
            else if($data['type_employee'] === TypeEmployeeEnum::NON_REGULIER->value)
            {
                
                $employeDetail = $this->employeeNCtrWRep->create($data['data']);


                if(!$employeDetail) throw new Exception("Error occur while creating type of employee", 1);

                $categoryEmployeId = $data['data']['category_of_employee_id'];

                $categoryEmployeeTauxId = $data['data']['category_of_employee_taux_id'] ?? null;

                $attributes = [
                    'date_debut' => $data['data']['date_debut'],
                    'category_of_employee_taux_id' =>$categoryEmployeeTauxId
                ];
                
                $mu = $employeDetail->categories()->attach($categoryEmployeId, $attributes);


                //$employeDetail->employee()->attach($this->model);
            }
            else throw new Exception("Unknown type of employee", 1);

            if(!$employeDetail) throw new Exception("Error occur while creating type of employee", 1);
            
            $att = $employeDetail->employees()->attach($theparent->id);

            $this->userReadWriteRepository->create(array_merge($data['user'], ["profilable_type"=>$this->model::class, "profilable_id"=>$this->model->id]));
           
            //$this->model = $this->model->user()->create($data['user']);

            return $this->model->refresh();
            
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }

    public function update($id, array $data):Employee
    {
        try {
            
            $employee = Employee::find($id);
            
            $employeDetail = null;

            
            if (($data['type_employee'] === TypeEmployeeEnum::NON_REGULIER->value) && isset($data['est_convertir'])) {
                // Si le type d'employé est non régulier et est_convertir est renseigné, appeler la fonction changing_type_employee
                $this->changing_type_employee($id, $data);
                
                return $employee->refresh();
            }
            
            if($data['type_employee'] === TypeEmployeeEnum::REGULIER->value)
            {
                $employeeContractuelId = $employee->employee_contractuel()->latest()->first()->id;
                
                $employeDetail = $this->employeeContRWRep->update($employeeContractuelId,$data['data']);

                if(!$employeDetail) throw new Exception("Error occur while updating type of employee", 1);

                $lastContract = $employeDetail->contracts()->whereNull('date_fin')->latest()->first();

                $contract = $this->contractReadW->update($lastContract->id,$data['data']);

                if (!$contract) throw new Exception("Error occur while updating contract",1);
                
                if (isset($data['data']['montant'])){
                    $montant=strval($data['data']['montant']);
                    $salary = $contract->salaires()->update(['montant' => $montant]);
                }
                
            }
            else if($data['type_employee'] === TypeEmployeeEnum::NON_REGULIER->value)
            {
                $employeeNonContractuelId = $employee->employee_temporaire()->latest()->first()->id;

                $employeDetail = $this->employeeNCtrWRep->update($employeeNonContractuelId,$data['data']);

                if(!$employeDetail) throw new Exception("Error occur while updating type of employee", 1);

            }
            
            // Update employee data with the provided data
    
            $employee->update($data);

            // Update associated user information
            $user_update = $this->userReadWriteRepository->update($employee->user->id,array_merge($data['user'], ["profilable_type"=>$this->model::class, "profilable_id"=>$employee->id]));


            if ($employee->user->id != $user_update->id) {
                $employee->user->associate($user_update);
            }
    
            return $employee->refresh();
            
        } catch (QueryException $exception) {
            
            throw new QueryException(message: "Error while updating the record.", previous: $exception);
        } catch (Throwable $exception) {
           
            throw new RepositoryException(message: "Error while updating the record.", previous: $exception);
        }
    }

    /**
     * Changing type of an employee.
     *  
     * @param   string      $id                 The id of the employee.
     * 
     * @param   array       $data               The data for changing type of an employee.
     * 
     * @return Employee                         The created record.
     *
     * @throws \Core\Utils\Exceptions\RepositoryException If there is an error while changing type of an employee.
     */
    protected function changing_type_employee($id, array $data):Employee
    {
        try {
            $employee = Employee::find($id);
            
            if(!$employee) throw new Exception("Error occur while geting the employee", 1);
    
            if ($employee->type_employee == TypeEmployeeEnum::NON_REGULIER) {
    
                $employeeNonContractuel = $employee->employee_temporaire()->latest()->first();
        
                if(!$employeeNonContractuel) throw new Exception("Error occur while geting the employee", 1);
    
                $employeeNonContractuel->est_convertir = true;
                $employeeNonContractuel->save();
    
                $category_emp = $employeeNonContractuel->categories()->wherePivot('date_fin', null)->wherePivot('category_of_employee_id', $data['data']['category_of_employee_id'])->latest()->first();
                
                if ($category_emp) {
                    DB::table('employee_non_contractuel_categories')
                        ->where('employee_non_contractuel_id', $employeeNonContractuel->id)
                        ->where('category_of_employee_id', $category_emp->id)
                        ->update(['date_fin' => now()]);
                }
                
                $employeDetail = $this->employeeContRWRep->create($data['data']);
    
                $contract = $this->contractReadW->create(array_merge($data['data'], ['employee_contractuel_id' => $employeDetail->id]));
    
                if (!$contract) throw new Exception("Error occur while creating contract",1);
    
                if (!isset($data['data']['poste_salaire_id'])){
                    if (!$contract->salaires()->exists()) {
                        $salary = $contract->salaires()->create($data['data']);
                    }
                }
                
                $att = $employeDetail->employees()->attach($employee->id);

                $employee->update(['type_employee'=>TypeEmployeeEnum::REGULIER]);

                return $employee->refresh();
    
            }
            else throw new Exception("Unknown type of employee", 1);
        }catch (QueryException $exception) {
            
            throw new QueryException(message: "Error while updating the record.", previous: $exception);
        } catch (Throwable $exception) {
           
            throw new RepositoryException(message: "Error while updating the record.", previous: $exception);
        }

    }
}