<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\DataTransfertObjects;

use App\Models\Finances\ExerciceComptable;
use Core\Utils\DataTransfertObjects\BaseDTO;

/**
 * Class ***`CreateExerciceComptableDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`ExerciceComptable`*** model.
 *
 * @package ***`\Domains\Finances\ExercicesComptable\DataTransfertObjects`***
 */
class CreateExerciceComptableDTO extends BaseDTO
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
        return ExerciceComptable::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "fiscal_year"           => ["required", "numeric", 'regex:/^0|[1-9]\d{3,}$/', 'unique:exercices_comptable,fiscal_year'],
            "periode_exercice_id"   => ["required", "exists:periodes_exercice,id"],
            "plan_comptable_id"     => ["required", "exists:plans_comptable,id"],
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