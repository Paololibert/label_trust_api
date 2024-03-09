<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\DataTransfertObjects;

use Domains\Users\People\DataTransfertObjects\UpdatePersonDTO;
use App\Models\EmployeeContractuel;
use Core\Utils\DataTransfertObjects\BaseDTO;

class UpdateEmployeeNonContractuelDTO extends BaseDTO
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
            'can_be_deleted'                => ['sometimes', 'boolean'],
            'category_of_employee_id'       => ['sometimes', 'string', 'exists:categories_of_employees,id'],
            'date_debut'                    => ['sometimes', 'date'],
            'category_taux_id'             => ['sometimes', 'string', 'exists:categorie_taux,id'],
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
        $default_messages = array_merge([
            'can_be_delete.boolean' => 'Le champ can_be_delete doit être un booléen.',
            'can_be_delete.in'      => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}
