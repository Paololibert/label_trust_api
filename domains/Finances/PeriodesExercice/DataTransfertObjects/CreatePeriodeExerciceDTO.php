<?php

declare(strict_types=1);

namespace Domains\Finances\PeriodesExercice\DataTransfertObjects;

use App\Models\Finances\PeriodeExercice;
use Core\Utils\DataTransfertObjects\BaseDTO;


/**
 * Class ***`CreatePeriodeExerciceDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`PeriodeExercice`*** model.
 *
 * @package ***`\Domains\Finances\PeriodesExercice\DataTransfertObjects`***
 */
class CreatePeriodeExerciceDTO extends BaseDTO
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
        return PeriodeExercice::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "name"            		=> ["required", "max:25", 'unique:periodes_exercice,name'],
            "date_debut_periode"    => ["required", "date", 'date_format:d/m'],
            "date_fin_periode"      => ["required", "date", 'date_format:d/m'],
            'can_be_deleted'        => ['sometimes', 'boolean', 'in:'.true.','.false]
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