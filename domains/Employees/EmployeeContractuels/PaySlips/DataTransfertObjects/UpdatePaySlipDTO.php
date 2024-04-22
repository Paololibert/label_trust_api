<?php

declare(strict_types=1);

namespace Domains\Employees\EmployeeContractuels\PaySlips\DataTransfertObjects;

use App\Models\Finances\PaySlip;
use Core\Utils\DataTransfertObjects\BaseDTO;

class UpdatePaySlipDTO extends BaseDTO
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
        return PaySlip::class;
    }


    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([//

            "items"                         => ["sometimes", "array"],
            "items.*"                       => ["distinct", "array"],
            "items.*.id"                    => ["sometimes", "distinct", "exists:pay_slip_items,id"],
            "items.*.libelle"               => ["sometimes", "string", "max:255"],
            "items.*.amount"                => ["sometimes", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            'periode_date'                  => ["sometimes", "date_format:m/Y"],
            "start_date"                    => ["sometimes", "date_format:Y-m-d"],
            "end_date"                      => ["sometimes", "date_format:Y-m-d", "after:start_date"],
            "issue_date"                    => ["sometimes", "date_format:Y-m-d"],
            "pay_slip_status"               => ["sometimes", "boolean"]
            
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
