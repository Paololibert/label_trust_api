<?php

declare(strict_types=1);

namespace Domains\Contrats\DataTransfertObjects;

use App\Models\Contract;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\TypeContratEnum;
use Illuminate\Validation\Rules\Enum;

class CreateContractDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return Contract::class;
    }


    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([//
            'reference'                          => ['sometimes', 'string'],
            'type_contract'                      => ['required', "string", new Enum(TypeContratEnum::class)],
            'duree'                              => ['required', 'numeric'],
            'date_debut'                         => ['sometimes', 'date'],
            'date_fin'                           => ['nullable', 'date'],
            'renouvelable'                       => ['required', 'boolean'],
            'poste_id'                           => ['required', 'string', 'exists:postes,id'],
            "poste_salaire_id"                   => ["present_if:montant,null", "sometimes", "uuid", "exists:poste_salaries,id"],
            "montant"                            => ["present_if:poste_salaire_id,null", "sometimes", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            'unite_mesures_id'                   => ['required', 'string', 'exists:unite_mesures,id'],
            'can_be_deleted'                     => ['sometimes', 'boolean'],
            "employee_contractuel_id"           => ['required','string', 'exists:employee_contractuels,id']

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
