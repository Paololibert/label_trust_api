<?php

declare(strict_types=1);

namespace Domains\Postes\PosteSalaries\DataTransfertObjects;

use App\Models\PosteSalary;
use Core\Utils\DataTransfertObjects\BaseDTO;

/**
 * Class ***`CreatePosteSalaryDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`PosteSalary`*** model.
 *
 * @package ***`\Domains\Postes\PosteSalaries\DataTransfertObjects`***
 */
class CreatePosteSalaryDTO extends BaseDTO
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
            'salaries.required'                          => 'Le champ salaries est requis.',
            'salaries.array'                             => 'Le champ salaries doit être un tableau.',
            'salaries.*.distinct'                        => 'Les éléments du tableau salaries ne doivent pas être en double.',
            'salaries.*.array'                           => 'Chaque élément du tableau salaries doit être un tableau.',
            'salaries.*.min'                             => 'Chaque élément du tableau salaries doit contenir au moins un élément.',
            'salaries.*.est_le_salaire_de_base.boolean'  => 'Le champ est_le_salaire_de_base doit être un booléen.',
            'salaries.*.est_le_salaire_de_base.in'       => 'Le champ est_le_salaire_de_base doit avoir une valeur "true" ou "false".',
            'salaries.*.salary_id.required'              => 'Le champ salary_id est requis.',
            'salaries.*.salary_id.exists'                => 'Le champ salary_id est invalide.',
            'salaries.*.can_be_deleted.boolean'          => 'Le champ can_be_deleted doit être un booléen.',
            'salaries.*.can_be_deleted.in'               => 'Le champ can_be_deleted doit avoir une valeur "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}