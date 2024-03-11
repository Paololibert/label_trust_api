<?php

declare(strict_types=1);

namespace Domains\Montants\DataTransfertObjects;

use App\Models\Montant;
use Core\Utils\DataTransfertObjects\BaseDTO;

/**
 * Class ***`CreateMontantDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`Montant`*** model.
 *
 * @package ***`\Domains\Montants\DataTransfertObjects`***
 */
class CreateMontantDTO extends BaseDTO
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
        return Montant::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "amount"                  => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
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