<?php

declare(strict_types=1);

namespace Domains\Employees\Repositories;

use App\Models\Employee;
use Core\Data\Repositories\Eloquent\EloquentReadWriteRepository;
use Core\Utils\Enums\TypeEmployeeEnum;
use Core\Utils\Exceptions\QueryException;
use Core\Utils\Exceptions\RepositoryException;
use Domains\Employees\EmployeeContractuels\Repositories\EmployeeContractuelReadWriteRepository;
use Domains\Employees\EmployeeNonContractuels\Repositories\EmployeeNonContractuelReadWriteRepository;
use Domains\Users\Repositories\UserReadWriteRepository;
use Exception;
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

    private $userReadWriteRepository;

    /**
     * Create a new EmployeeReadWriteRepository instance.
     *
     * @param  \App\Models\Employee $model
     * @return void
     */
    public function __construct(Employee $model, /* EmployeeContractuelReadWriteRepository $employeeContRWRep, */EmployeeNonContractuelReadWriteRepository $employeeNonContRWRep ,UserReadWriteRepository $userReadWriteRepository)
    {
        parent::__construct($model);
        /* $this->employeeContRWRep = $employeeContRWRep;*/
        $this->employeeNCtrWRep = $employeeNonContRWRep; 
        $this->userReadWriteRepository = $userReadWriteRepository;
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

            //dd($data['user']);

            $this->model = parent::create($data);

            $employeDetail = null;


            if($data['type_employee'] === TypeEmployeeEnum::REGULIER->value)
            {
                //$employeDetail = $this->employeeContRWRep->create($data['data']);
            }
            else if($data['type_employee'] === TypeEmployeeEnum::NON_REGULIER->value)
            {
                $employeDetail = $this->employeeNCtrWRep->create($data['data']);

                if(!$employeDetail) throw new Exception("Error occur while creating type of employee", 1);
                
                $this->model->employee_temporaire()->attach($employeDetail->id);

                //$employeDetail->employee()->attach($this->model);
            }
            else throw new Exception("Unknown type of employee", 1);

            if(!$employeDetail) throw new Exception("Error occur while creating type of employee", 1);



            $this->userReadWriteRepository->create(array_merge($data['user'], ["profilable_type"=>$this->model::class, "profilable_id"=>$this->model->id]));

            //$this->model = $this->model->user()->create($data['user']);

            return $this->model->refresh();
            
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while creating the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while creating the record.", previous: $exception);
        }
    }
}