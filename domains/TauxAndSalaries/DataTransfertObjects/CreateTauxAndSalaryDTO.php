<?php

declare(strict_types=1);

namespace Domains\TauxAndSalaries\DataTransfertObjects;

use App\Models\TauxAndSalary;
use Core\Utils\DataTransfertObjects\BaseDTO;

/**
 * Class ***`CreateTauxAndSalaryDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`TauxAndSalary`*** model.
 *
 * @package ***`\Domains\TauxAndSalaries\DataTransfertObjects`***
 */
class CreateTauxAndSalaryDTO extends BaseDTO
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
        return TauxAndSalary::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "rate"                  => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            "hint"                  => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            "unite_mesure_id"       => ["required", "exists:unite_mesures,id"],
            'can_be_deleted'        => ['nullable', 'boolean', 'in:'.true.','.false]
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
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}