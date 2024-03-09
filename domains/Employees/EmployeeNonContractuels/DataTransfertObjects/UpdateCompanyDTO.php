<?php

declare(strict_types=1);

namespace Domains\Employees\DataTransfertObjects;

use Domains\Users\People\DataTransfertObjects\UpdatePersonDTO;
use App\Models\EmployeeContractuel;
use Core\Utils\DataTransfertObjects\BaseDTO;

class UpdateEmployeeContractuelDTO extends BaseDTO
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
        return EmployeeContractuel::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $updatePersonDTO = new UpdatePersonDTO();
        $personRules = $updatePersonDTO->rules();

        $rules = array_merge([
            'matricule'                   => ['sometimes', 'string'],
            'type_employee'               => ['sometimes', 'string'],
            'statut_employee'             => ['sometimes', 'string'],
            'can_be_deleted'              => ['sometimes', 'boolean'],
            'date_debut'                  => ['sometimes', 'date'],
            'poste_id'              => ['sometimes', 'string', 'exists:postes,id'],
            'employee_contractuel_id' => ['sometimes', 'string', 'exists:employee_contractuels,id'],
            'unite_mesures_id'      => ['sometimes', 'string', 'exists:unite_mesures,id'],
            'can_be_deleted'        => ['sometimes', 'boolean']
        ], $personRules);

        return $this->rules = parent::rules($rules);
    }

    /**
     * Get the validation error messages for the DTO object.
     *
     * @return array The validation error messages.
     */
    public function messages(array $messages = []): array
    {
        $updatePersonDTO = new UpdatePersonDTO();
        $personMessages = $updatePersonDTO->messages();

        return $this->messages = parent::messages($personMessages);
    }
}
