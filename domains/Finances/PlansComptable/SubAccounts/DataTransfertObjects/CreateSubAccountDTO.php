<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\SubAccounts\DataTransfertObjects;

use App\Models\Finances\SubAccount;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Domains\Finances\Comptes\DataTransfertObjects\CreateCompteDTO;
use Illuminate\Validation\Rule;

/**
 * Class ***`CreateSubAccountDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`SubAccount`*** model.
 *
 * @package ***`\Domains\Finances\PlansComptable\SubAccounts\DataTransfertObjects`***
 */
class CreateSubAccountDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();

        //dd(request()['accounts']);

        /* if(!isset(request()['sub_accounts']['sous_compte_id']) && !request('sous_compte_id')){
            $this->merge(new CreateCompteDTO(), 'accounts.*.sub_accounts.*.compte_data');
        } */
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
            "accounts.*.sub_accounts.*.account_number"          => ["required", "string", "max:120", Rule::unique('plan_comptable_compte_sous_comptes', 'account_number')->whereNull('deleted_at')],
            "accounts.*.sub_accounts.*.sub_account_id"          => ["sometimes", "exists:plan_comptable_compte_sous_comptes,id"],
            "accounts.*.sub_accounts.*.principal_account_id"    => ["sometimes", "exists:plan_comptable_comptes,id"],
            "accounts.*.sub_accounts.*.sous_compte_id"          => ["sometimes", "exists:comptes,id"],
            'can_be_deleted'                                    => ['sometimes', 'boolean', 'in:'.true.','.false],
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