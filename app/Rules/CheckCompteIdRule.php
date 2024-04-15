<?php

namespace App\Rules;

use Closure;
use Domains\Finances\Comptes\DataTransfertObjects\CreateCompteDTO;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckCompteIdRule implements ValidationRule
{
    /**
     * @var mixed
     */
    protected mixed $dto;

    /**
     * @return void
     */
    public function __construct(mixed &$dto)
    {
        $this->dto      = $dto;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //dump("Check compte id rule");

        foreach ($this->dto->getProperties()["accounts"] as $key => $account) {
            if (!isset($account['compte_id'])) {

                $this->dto->merge(new CreateCompteDTO(data: $this->dto->getProperties(), rules: $this->dto->additionalValidationRules), "$key.compte_data");
                break;
            }
        }

        /* foreach ($value as $account) {
            if (!isset($account['compte_id'])) {
                // If compte_id is missing, merge rules from CreateCompteDTO
                $compteDTO = new CreateCompteDTO(data: $this->dto->getProperties(), rules: $this->dto->additionalValidationRules);
                $this->dto->merge($compteDTO, $attribute . ".compte_data");
            }
        } */
        
        //return true; // Validation passes if compte_id is present in all accounts
        /* if (!isset(request()[$attribute . ".compte_id"])) {
            $this->dto->merge(new CreateCompteDTO(data: $this->dto->getProperties(), rules: $this->dto->additionalValidationRules), $attribute . ".compte_data");
        } */
    }
}
