<?php

declare(strict_types=1);

namespace Domains\Employees\DataTransfertObjects;

use App\Models\Employee;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\StatutEmployeeEnum;
use Core\Utils\Enums\TypeEmployeeEnum;
use Domains\Employees\EmployeeContractuels\DataTransfertObjects\UpdateEmployeeContractuelDTO;
use Domains\Employees\EmployeeNonContractuels\DataTransfertObjects\UpdateEmployeeNonContractuelDTO;
use Domains\Users\DataTransfertObjects\UpdateUserDTO;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

/**
 * Class ***`UpdateEmployeeDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Employee`*** model.
 *
 * @package ***`\Domains\Employees\DataTransfertObjects`***
 */
class UpdateEmployeeDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();
        
        if(request('type_employee')){
            switch (request()->type_employee) {
                case TypeEmployeeEnum::NON_REGULIER->value:
                    $this->merge(new UpdateEmployeeNonContractuelDTO, 'data', ["required", "array"]);
                    $this->adding_user_id_to_route();
                     
                    break;                
                default:
                    $this->merge(new UpdateEmployeeContractuelDTO, 'data', ["required", "array"]);
                    $this->adding_user_id_to_route();
                    break;
            }
        }
        
        $this->merge(new UpdateUserDTO, 'user', ["required", "array"]);
    }

    protected function adding_user_id_to_route()
    {
        if (!($id = Employee::find(request()->route("employee_id"))?->user?->id)){
            throw ValidationException::withMessages(["User not found"]);
        }
        request()->route()->setParameter('user_id', $id);
    }
    
    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return Employee::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            'matricule'                 => ['sometimes',"string",'unique:employees,matricule'],
            "type_employee"             => ['sometimes', "string", new Enum(TypeEmployeeEnum::class)],
            'statut_employee'           => ['sometimes', "string", new Enum(StatutEmployeeEnum::class)],
            'can_be_deleted'            => ['sometimes', 'boolean', 'in:'.true.','.false],
        ], $rules);

        return $this->rules = parent::rules($rules);
    }

    /**
     * Get the validation error messages for the DTO object.
     *
     * @return array The validation error messages.
     */
    public function messages(array $messages = []): array
    {
        $default_messages = array_merge([
            'can_be_delete.boolean' => 'Le champ can_be_delete doit être un booléen.',
            'can_be_delete.in'      => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}