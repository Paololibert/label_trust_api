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

        if (!array_key_exists('accounts.*.compte_id', $this->rules())) {
            $this->merge(new CreateCompteDTO(), 'accounts.*.compte_data');
        }

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
            "accounts.required"                     => "Les comptes sont requis.",
            "accounts.array"                        => "Les comptes doivent être un tableau.",
            "accounts.*.distinct"                   => "Chaque compte doit être unique dans la liste.",
            "accounts.*.account_number.required"    => "Le numéro de compte est requis.",
            "accounts.*.account_number.string"      => "Le numéro de compte doit être une chaîne de caractères.",
            "accounts.*.account_number.max"         => "Le numéro de compte ne peut pas dépasser :max caractères.",
            "accounts.*.account_number.unique"      => "Ce numéro de compte est déjà utilisé.",
            "accounts.*.classe_id.required"         => "La classe de compte est requise.",
            "accounts.*.classe_id.exists"           => "La classe de compte sélectionnée n'existe pas.",
            "accounts.*.compte_id.exists"           => "Le compte sélectionné n'existe pas.",
            "accounts.*.can_be_deleted.boolean"     => "Le champ indiquant si le compte peut être supprimé doit être un booléen.",
            "accounts.*.can_be_deleted.in"          => "Le champ indiquant si le compte peut être supprimé doit être 'true' ou 'false'."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}