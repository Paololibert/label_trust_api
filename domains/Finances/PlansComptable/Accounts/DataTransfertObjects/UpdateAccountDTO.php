<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\DataTransfertObjects;

use App\Models\Finances\Account;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Domains\Finances\PlansComptable\Accounts\SubAccounts\DataTransfertObjects\UpdateSubAccountDTO;
use Illuminate\Validation\Rule;

/**
 * Class ***`UpdateAccountDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Account`*** model.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\DataTransfertObjects`***
 */
class UpdateAccountDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();

        if (array_key_exists('accounts.*.sub_accounts', $this->rules())) {
            $this->merge(new UpdateSubAccountDTO());
        }
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
            "accounts.*.id"                     => ["required", "exists:plan_comptable_comptes,id"],
            "accounts.*.account_number"         => ["sometimes", "string", "max:120", Rule::unique('plan_comptable_comptes', 'account_number')->ignore(request("accounts.*.account_id"))->whereNull('deleted_at')],
            "accounts.*.classe_id"              => ["sometimes", "exists:classes_de_compte,id"],
            "accounts.*.compte_id"              => ["sometimes", "exists:comptes,id"],
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
            'can_be_delete.boolean' => 'Le champ can_be_delete doit être un booléen.',
            'can_be_delete.in'      => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}