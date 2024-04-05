<?php

namespace App\Rules;

use App\Models\Finances\ExerciceComptable;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AccountNumberExistsInEitherTable implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!ExerciceComptable::findOrfail(request("exercice_comptable_id"))->plan_comptable->findAccountOrSubAccount(accountNumber: $value)) {
            // Si les totaux ne sont pas équilibrés, appeler la méthode $fail pour indiquer l'échec de la validation
            $fail("The ".array_slice(explode(".", $attribute), -1)[0]." does not exist for the plan comptable.");
        }
    }
}
