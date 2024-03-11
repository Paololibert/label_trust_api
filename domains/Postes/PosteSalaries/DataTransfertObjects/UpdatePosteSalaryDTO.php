<?php

declare(strict_types=1);

namespace Domains\Postes\PosteSalaries\DataTransfertObjects;

use App\Models\PosteSalary;
use Core\Utils\DataTransfertObjects\BaseDTO;

/**
 * Class ***`UpdatePosteSalaryDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`PosteSalary`*** model.
 *
 * @package ***`\Domains\Postes\PosteSalaries\DataTransfertObjects`***
 */
class UpdatePosteSalaryDTO extends BaseDTO
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
        return PosteSalary::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "salaries"                          => ["required", "array"],
            "salaries.*"                        => ["distinct", "array", "min:1"],
            'salaries.*.est_le_salaire_de_base' => ['boolean', 'in:'.true.','.false],
            "salaries.*.salary_id"              => ["required", "exists:taux_and_salaries,id"],
            'salaries.*.can_be_deleted'         => ['nullable', 'boolean', 'in:'.true.','.false]
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