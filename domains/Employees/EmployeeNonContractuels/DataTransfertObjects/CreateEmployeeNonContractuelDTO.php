<?php

declare(strict_types=1);

namespace Domains\Employees\DataTransfertObjects;

use Domains\Users\People\DataTransfertObjects\CreatePersonDTO;
use App\Models\EmployeeNonContractuel;
use Core\Utils\DataTransfertObjects\BaseDTO;

class CreateEmployeeNonContractuelDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return EmployeeNonContractuel::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $personDTO = new CreatePersonDTO();
        $personRules = $personDTO->rules();

        $rules = array_merge([
            'matricule'                   => ['required', 'string'],
            'type_employee'               => ['required', 'string'],
            'statut_employee'             => ['required', 'string'],
            'can_be_deleted'              => ['sometimes', 'boolean'],
            'categories_of_employee_id' => ['sometimes', 'string', 'exists:categories_of_employees,id'],
            'date_debut'                  => ['required', 'date'],
        ], $personRules);

        
        /* if($this->hasProperty('type_of_account')){
            switch ($this->getProperty('type_of_account')) {
                case 'moral':
                    $this->merge(CreatePersonDTO::fromRequest(Request()));
                    break;
                
                default:
                    $this->merge(CreatePersonDTO::fromRequest(Request()));
                    break;
            }
        } */

        return $this->rules = parent::rules($rules);

    }

    /**
     * Get the validation error messages for the DTO object.
     *
     * @return array The validation error messages.
     */
    public function messages(array $messages = []): array
    {
        $personDTO = new CreatePersonDTO();
        $personMessages = $personDTO->messages();

        return $this->messages = parent::messages($personMessages);
    }
}
