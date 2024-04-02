<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EquilibreEcritureComptable implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Calculer la somme des montants de crédit et de débit
        $totalCredit = collect($value['lignes_ecriture'])->where('type_ecriture_compte', 'credit')->sum('montant');
        $totalDebit = collect($value['lignes_ecriture'])->where('type_ecriture_compte', 'debit')->sum('montant');
        
        // Vérifier si les totaux sont équilibrés
        if ($totalCredit !== $totalDebit) {
            // Si les totaux ne sont pas équilibrés, appeler la méthode $fail pour indiquer l'échec de la validation
            $fail($this->message);
        }
    }
    protected $message = 'Les totaux en crédit et en débit ne sont pas équilibrés.';

    /* public function passes($attribute, $value)
    {
        // Calculer la somme des montants de crédit et de débit
        $totalCredit = $value['lignes_ecriture']->where('type_ecriture_compte', 'credit')->sum('montant');
        $totalDebit = $value['lignes_ecriture']->where('type_ecriture_compte', 'debit')->sum('montant');
        
        // Vérifier si les totaux sont équilibrés
        return $totalCredit === $totalDebit;
    }

    public function message()
    {
        return $this->message;
    } */
}
