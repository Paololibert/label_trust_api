<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\DataTransfertObjects;

use App\Models\Finances\PlanComptable;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Domains\Finances\PlansComptable\Accounts\DataTransfertObjects\CreateAccountDTO;
use Illuminate\Validation\Rule;

/**
 * Class ***`CreatePlanComptableDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`PlanComptable`*** model.
 *
 * @package ***`\Domains\Finances\PlansComptable\DataTransfertObjects`***
 */
class CreatePlanComptableDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();

        if (array_key_exists('accounts', $this->rules())) {
            $this->merge(new CreateAccountDTO());
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
            "name"            		=> ["required", "string", "max:25", Rule::unique('plans_comptable', 'name')->whereNull('deleted_at')],
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
            'can_be_deleted.boolean' => 'Le champ can_be_deleted doit être un booléen.',
            'can_be_deleted.in'      => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}