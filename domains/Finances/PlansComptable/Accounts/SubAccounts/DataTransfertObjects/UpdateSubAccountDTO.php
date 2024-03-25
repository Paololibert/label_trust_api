<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\SubAccounts\DataTransfertObjects;

use App\Models\Finances\SubAccount;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Illuminate\Validation\Rule;

/**
 * Class ***`UpdateSubAccountDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`SubAccount`*** model.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\SubAccounts\DataTransfertObjects`***
 */
class UpdateSubAccountDTO extends BaseDTO
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
        return SubAccount::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([

            "accounts.*.sub_accounts"                           => ["required", "array"],
            "accounts.*.sub_accounts.*"                         => ["distinct", "array"],
            "accounts.*.sub_accounts.*.account_number"          => ["required", "string", "max:120", Rule::unique('plan_comptable_compte_sous_comptes', 'account_number')->ignore(request()->route("sub_account_id") )->whereNull('deleted_at')],
            "accounts.*.sub_accounts.*.sub_account_id"          => ["sometimes", "exists:plan_comptable_compte_sous_comptes,id"],
            "accounts.*.sub_accounts.*.principal_account_id"    => ["sometimes", "exists:plan_comptable_comptes,id"],
            "accounts.*.sub_accounts.*.sous_compte_id"          => ["sometimes", "exists:comptes,id"],
            'accounts.*.sub_accounts.*.can_be_deleted'          => ['sometimes', 'boolean', 'in:'.true.','.false],
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