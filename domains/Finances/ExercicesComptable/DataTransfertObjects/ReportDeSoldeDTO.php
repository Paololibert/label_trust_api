<?php

declare(strict_types=1);

namespace Domains\Finances\ExercicesComptable\DataTransfertObjects;

use App\Models\Finances\ExerciceComptable;
use App\Models\Finances\PlanComptable;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Domains\Finances\PlansComptable\Accounts\DataTransfertObjects\AccountDTO;
use Illuminate\Validation\Rule;

/**
 * Class ***`ReportDeSoldeDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`ExerciceComptable`*** model.
 *
 * @package ***`\Domains\Finances\ExercicesComptable\DataTransfertObjects`***
 */
class ReportDeSoldeDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();
        //dd(request()->route("exercice_comptable_id"));
        //$this->merge(new AccountDTO());
    }

    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return ExerciceComptable::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "accounts"                                                              => ["required", "array"],
            "accounts.*"                                                            => ["distinct", "array"],
            "accounts.*.account_number"                                             => ["required", "distinct", "exists:plan_comptable_comptes,account_number", Rule::exists("plan_comptable_comptes", "account_number")->where("plan_comptable_id", ExerciceComptable::find(request()->route("exercice_comptable_id"))?->plan_comptable_id)],
            "accounts.*.solde_debit"                                                => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            "accounts.*.solde_credit"                                               => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],

            "accounts.*.sub_accounts"                                               => ["sometimes", "array"],
            "accounts.*.sub_accounts.*"                                             => ["distinct", "array"],
            "accounts.*.sub_accounts.*.account_number"                                => ["required", "distinct", "exists:plan_comptable_compte_sous_comptes,account_number"],
            "accounts.*.sub_accounts.*.solde_debit"                                   => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            "accounts.*.sub_accounts.*.solde_credit"                                  => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            "accounts.*.sub_accounts.*.sub_divisions"                                 => ["sometimes", "array"],
            "accounts.*.sub_accounts.*.sub_divisions.*"                               => ["distinct", "array"],
            "accounts.*.sub_accounts.*.sub_divisions.*.account_number"                => ["required", "distinct", "exists:plan_comptable_compte_sous_comptes,account_number"],
            "accounts.*.sub_accounts.*.sub_divisions.*.solde_debit"                   => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            "accounts.*.sub_accounts.*.sub_divisions.*.solde_credit"                  => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
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
            "fiscal_year.required"              => "Le champ année fiscale est requis.",
            "fiscal_year.numeric"               => "Le champ année fiscale doit être numérique.",
            "fiscal_year.regex"                 => "Le champ année fiscale doit être au format valide.",
            "fiscal_year.unique"                => "L'année fiscale spécifiée existe déjà dans la base de données.",
            "periode_exercice_id.required"      => "Le champ période d'exercice est requis.",
            "periode_exercice_id.exists"        => "La période d'exercice spécifiée est invalide.",
            "plan_comptable_id.required"        => "Le champ plan comptable est requis.",
            "plan_comptable_id.exists"          => "Le plan comptable spécifié est invalide.",
            "can_be_deleted.boolean"            => "Le champ peut être supprimé doit être un booléen.",
            "can_be_deleted.in"                 => "La valeur du champ peut être supprimée doit être vrai ou faux."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}
