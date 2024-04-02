<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\DataTransfertObjects;

use App\Models\Finances\Account;
use Core\Utils\DataTransfertObjects\BaseDTO;

/**
 * Class ***`AccountDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Account`*** model.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\DataTransfertObjects`***
 */
class AccountDTO extends BaseDTO
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
        return Account::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "accounts"                          => ["required", "array"],
            "accounts.*"                        => ["distinct", "array"],
            "accounts.*.id"                     => ["required", "distinct", "exists:plan_comptable_comptes,id"],
            "accounts.*.solde_debit"            => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            "accounts.*.solde_credit"           => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            'accounts.*.can_be_deleted'         => ['sometimes', 'boolean', 'in:'.true.','.false]
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
            'accounts.required'                     => 'The accounts field is required.',
            'accounts.array'                        => 'The accounts must be an array.',
            'accounts.*.distinct'                   => 'Each account must be unique in the list.',
            'accounts.*.exists'                     => 'The selected account does not exist.',
            'accounts.*.can_be_deleted.boolean'     => 'The can_be_delete field must be a boolean.',
            'accounts.*.can_be_deleted.in'          => 'The can_be_delete field must be "true" or "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}