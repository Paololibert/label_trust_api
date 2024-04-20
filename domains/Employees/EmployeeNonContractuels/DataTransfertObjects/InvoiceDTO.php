<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeNonContractuels\DataTransfertObjects;

use App\Models\Finances\EmployeeNonContractuelInvoice;
use Core\Utils\DataTransfertObjects\BaseDTO;

class InvoiceDTO extends BaseDTO
{

    /**
     * @var array
     */
    public array $additionalValidationRules;

    /**
     * Constructor 
     * 
     * @return void
     */
    public function __construct(array $data = [], array $rules = [])
    {
        parent::__construct(data: $data, rules: $rules);

        $this->additionalValidationRules    = $rules;
    }

    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return EmployeeNonContractuelInvoice::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            //'employee_non_contractuel_id'        => ['required', 'string', 'exists:employee_non_contractuel_invoices,id'],
            "items"                              => ["required", "array"],
            "items.*"                            => ["distinct", "array"],
            "items.*.quantity"                   => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            //"items.*.unit_price"                 => ["required", "numeric", 'regex:/^0|[1-9]\d+$/'],
            "items.*.unite_travaille_id"         => ["required", "distinct", "exists:unite_travailles,id"]
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
