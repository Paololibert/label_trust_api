<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\DataTransfertObjects;

use App\Models\Finances\Account;
use App\Rules\CheckCompteIdRule;
use App\Rules\CheckSubAccountsRule;
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
    /**
     * @var array
     */
    public array $additionalValidationRules;

    public function __construct(array $data = [], array $rules = [])
    {
        parent::__construct(data: $data, rules: $rules);

        $this->additionalValidationRules    = $rules;

        // Check if 'compte_id' exists in any nested array
        foreach ($this->properties["accounts"] as $key => $account) {
            if (!isset($account['compte_id'])) {
                $this->merge(new CreateCompteDTO(data: $data, rules: $rules), array_key: "accounts.$key.compte_data");
            } else if (isset($account['sub_accounts'])) {
                $this->merge(new CreateSubAccountDTO(data: $data, rules: $rules)/* , "accounts.$key.sub_accounts" */);
            }
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
        //dd(Account::where(["account_number" => request()["accounts"][0]["account_number"]])->first());
        $rules = array_merge([
            "accounts"                          => ["required", "array"],
            "accounts.*"                        => ["distinct", "array"],
            "accounts.*.account_number"         => ["required", "string", "max:120", Rule::unique('plan_comptable_comptes', 'account_number')->whereNull('deleted_at')],
            "accounts.*.classe_id"              => ["required", "exists:classes_de_compte,id"],
            "accounts.*.compte_id"              => ["sometimes", "distinct", "exists:comptes,id"],
            'accounts.*.can_be_deleted'         => ['sometimes', 'boolean', 'in:' . true . ',' . false],
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
