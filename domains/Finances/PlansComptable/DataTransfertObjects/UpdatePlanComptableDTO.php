<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\DataTransfertObjects;

use App\Models\Finances\PlanComptable;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Domains\Finances\PlansComptable\Accounts\DataTransfertObjects\UpdateAccountDTO;

/**
 * Class ***`UpdatePlanComptableDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`PlanComptable`*** model.
 *
 * @package ***`\Domains\Finances\PlansComptable\DataTransfertObjects`***
 */
class UpdatePlanComptableDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();

        if (array_key_exists('accounts', $this->rules())) {
            $this->merge(new UpdateAccountDTO());
        }
    }
    
    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return PlanComptable::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "name"            		=> ["required", "string", "max:25", "unique_ignore_case:plans_comptable,name," . request()->route("plan_comptable_id"). ',id'],
            'can_be_deleted'        => ['sometimes', 'boolean', 'in:'.true.','.false],
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
            "name.required"             => "Le champ name est requis.",
            "name.string"               => "Le champ name doit être une chaîne de caractères.",
            "name.max"                  => "Le champ name ne doit pas dépasser :max caractères.",
            "name.unique_ignore_case"   => "La valeur saisie pour le champ name est déjà utilisée.", // Customize the message as needed
            "can_be_delete.boolean"     => "Le champ can_be_delete doit être un booléen.",
            "can_be_delete.in"          => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}