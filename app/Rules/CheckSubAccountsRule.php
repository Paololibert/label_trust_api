<?php

namespace App\Rules;

use Closure;
use Domains\Finances\PlansComptable\Accounts\SubAccounts\DataTransfertObjects\CreateSubAccountDTO;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckSubAccountsRule implements ValidationRule
{

    protected $dto;

    public function __construct(&$dto)
    {
        $this->dto = $dto;
    }
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value as $account) {
            if (!isset($account['sub_accounts'])) {
                // If sub_accounts is missing, merge rules from CreateSubAccountDTO
                $subAccountDTO = new CreateSubAccountDTO(data: $this->dto->getProperties(), rules: $this->dto->additionalValidationRules);
                $this->dto->merge($subAccountDTO);
            }
        }
    }
}
