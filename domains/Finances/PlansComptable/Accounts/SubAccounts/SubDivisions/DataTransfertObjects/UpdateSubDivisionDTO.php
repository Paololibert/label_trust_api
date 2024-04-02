<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\SubAccounts\SubDivisions\DataTransfertObjects;

use App\Models\Finances\SubAccount;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Illuminate\Validation\Rule;

/**
 * Class ***`UpdateSubDivisionDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`SubAccount`*** model.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\SubAccounts\SubDivisions\DataTransfertObjects`***
 */
class UpdateSubDivisionDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();

        if (array_key_exists('sub_accounts.*.sub_accounts.*.sub_divisions.*.sub_divisions', $this->rules())) {
            $this->merge(new UpdateSubDivisionDTO());
        }
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
            "accounts.*.sub_accounts.*.sub_divisions"                           => ["required", "array"],
            "accounts.*.sub_accounts.*.sub_divisions.*"                         => ["distinct", "array"],
            "accounts.*.sub_accounts.*.sub_divisions.*.id"                      => ["required", "distinct", "exists:plan_comptable_compte_sous_comptes,id"],
            "accounts.*.sub_accounts.*.sub_divisions.*.account_number"          => ["required", "string", "max:120", Rule::unique('plan_comptable_compte_sous_comptes', 'account_number')->ignore(request()->route("sub_account_id"))->whereNull('deleted_at')],
            "accounts.*.sub_accounts.*.sub_divisions.*.sub_account_id"          => ["sometimes", "exists:plan_comptable_compte_sous_comptes,id"],
            "accounts.*.sub_accounts.*.sub_divisions.*.principal_account_id"    => ["sometimes", "exists:plan_comptable_comptes,id"],
            "accounts.*.sub_accounts.*.sub_divisions.*.sous_compte_id"          => ["sometimes", "distinct", "exists:comptes,id"],
            'accounts.*.sub_accounts.*.sub_divisions.*.can_be_deleted'          => ['sometimes', 'boolean', 'in:' . true . ',' . false],
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

            "accounts.*.sub_accounts.*.sub_divisions.required"                          => "Les subdivisions sont requises.",
            "accounts.*.sub_accounts.*.sub_divisions.array"                             => "Les subdivisions doivent être un tableau.",
            "accounts.*.sub_accounts.*.sub_divisions.*.distinct"                        => "Chaque subdivision doit être unique dans la liste.",
            "accounts.*.sub_accounts.*.sub_divisions.*.id.required"                     => "L'ID de la subdivision est requis.",
            "accounts.*.sub_accounts.*.sub_divisions.*.id.exists"                       => "L'ID de la subdivision sélectionnée n'existe pas.",
            "accounts.*.sub_accounts.*.sub_divisions.*.account_number.required"         => "Le numéro de compte est requis pour la subdivision.",
            "accounts.*.sub_accounts.*.sub_divisions.*.account_number.string"           => "Le numéro de compte de la subdivision doit être une chaîne de caractères.",
            "accounts.*.sub_accounts.*.sub_divisions.*.account_number.max"              => "Le numéro de compte de la subdivision ne peut pas dépasser :max caractères.",
            "accounts.*.sub_accounts.*.sub_divisions.*.account_number.unique"           => "Ce numéro de compte est déjà utilisé pour une autre subdivision.",
            "accounts.*.sub_accounts.*.sub_divisions.*.sub_account_id.exists"           => "Le compte de subdivision sélectionné n'existe pas.",
            'accounts.*.sub_accounts.*.sub_divisions.*.principal_account_id.exists'     => "Le compte principal sélectionné n'existe pas.",
            'accounts.*.sub_accounts.*.sub_divisions.*.sous_compte_id.exists'           => "Le sous-compte sélectionné n'existe pas.",
            'accounts.*.sub_accounts.*.sub_divisions.*.can_be_deleted.boolean'          => "Le champ indiquant si la subdivision peut être supprimée doit être un booléen.",
            "accounts.*.sub_accounts.*.sub_divisions.*.can_be_deleted.in"               => "Le champ indiquant si la subdivision peut être supprimée doit être 'true' ou 'false'."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}
