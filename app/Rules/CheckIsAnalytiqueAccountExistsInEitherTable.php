<?php

namespace App\Rules;

use App\Models\Finances\ExerciceComptable;
use Closure;
use Core\Utils\Enums\TypeCompteEnum;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckIsAnalytiqueAccountExistsInEitherTable implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!($account = ExerciceComptable::findOrfail(request("exercice_comptable_id"))->plan_comptable->findAccountOrSubAccount(accountNumber: $value))) {
            // Si les totaux ne sont pas équilibrés, appeler la méthode $fail pour indiquer l'échec de la validation
            $fail("The ".array_slice(explode(".", $attribute), -1)[0]." does not exist for the plan comptable.");
        }

        if($account->compte->type_de_compte !== TypeCompteEnum::ANALYTIQUE){
             // Si les totaux ne sont pas équilibrés, appeler la méthode $fail pour indiquer l'échec de la validation
             $fail("The ".array_slice(explode(".", $attribute), -1)[0]." is not an analytique account.");
        }
    }
}
