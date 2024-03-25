<?php

declare(strict_types=1);

namespace Domains\Finances\Comptes\DataTransfertObjects;

use App\Models\Finances\Compte;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\TypeCompteEnum;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`CreateCompteDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`Compte`*** model.
 *
 * @package ***`\Domains\Finances\Comptes\DataTransfertObjects`***
 */
class CreateCompteDTO extends BaseDTO
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
        return Compte::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            'type_de_compte'            => ['required', "string", new Enum(TypeCompteEnum::class)],
            "name"            		    => ["string", "required", "max:120", 'unique:comptes,name'],
            "categorie_de_compte_id"    => ["required", "exists:categories_de_compte,id"],
            'can_be_deleted'            => ['sometimes', 'boolean', 'in:'.true.','.false],
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