<?php

declare(strict_types=1);

namespace Domains\Employees\DataTransfertObjects;

use App\Models\Employee;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\StatutEmployeeEnum;
use Core\Utils\Enums\TypeEmployeeEnum;
use Domains\Employees\EmployeeContractuels\DataTransfertObjects\CreateEmployeeContractuelDTO;
use Domains\Employees\EmployeeNonContractuels\DataTransfertObjects\CreateEmployeeNonContractuelDTO;
use Domains\Users\DataTransfertObjects\CreateUserDTO;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`CreateEmployeeDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`Employee`*** model.
 *
 * @package ***`\Domains\Employees\DataTransfertObjects`***
 */
class CreateEmployeeDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();
        
       
        if(request('type_employee')){
            switch (request()->type_employee) {
                case TypeEmployeeEnum::NON_REGULIER->value:
                    $this->merge(new CreateEmployeeNonContractuelDTO, 'data', ["required", "array"]);
                    break;                
                default:
                    $this->merge(new CreateEmployeeContractuelDTO, 'data', ["required", "array"]);
                    break;
            }
        }
        $this->merge(new CreateUserDTO, 'user', ["required", "array"]);
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
            'matricule'             => ['required',"string"],
            "type_employee"         => ['required', "string", new Enum(TypeEmployeeEnum::class)],
            'can_be_deleted'        => ['sometimes', 'boolean', 'in:'.true.','.false],
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
            'can_be_deleted.boolean' => 'Le champ can_be_deleted doit être un booléen.',
            'can_be_deleted.in'      => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}