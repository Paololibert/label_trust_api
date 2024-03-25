<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\DataTransfertObjects;

use App\Models\Finances\Account;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Domains\Finances\Comptes\DataTransfertObjects\CreateCompteDTO;
use Domains\Finances\PlansComptable\Accounts\SubAccounts\DataTransfertObjects\CreateSubAccountDTO;
use Illuminate\Validation\Rule;

/**
 * Class ***`CreateAccountDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`Account`*** model.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\DataTransfertObjects`***
 */
class CreateAccountDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();

        //if(!isset(request()['compte_id']) && !request('compte_id')){
        if (!array_key_exists('accounts.*.compte_id', $this->rules())) {
            $this->merge(new CreateCompteDTO(), 'accounts.*.compte_data');
        }

        //if(!isset(request()['sub_accounts'])){
        if (array_key_exists('accounts.*.sub_accounts', $this->rules())) {
            $this->merge(new CreateSubAccountDTO());
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
            "accounts.*.account_number"         => ["required", "string", "max:120", Rule::unique('plan_comptable_comptes', 'account_number')->whereNull('deleted_at')],
            "accounts.*.classe_id"              => ["required", "exists:classes_de_compte,id"],
            "accounts.*.compte_id"              => ["sometimes", "exists:comptes,id"],
            'accounts.*.can_be_deleted'         => ['sometimes', 'boolean', 'in:'.true.','.false],
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