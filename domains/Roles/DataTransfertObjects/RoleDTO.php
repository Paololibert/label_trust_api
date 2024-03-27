<?php

declare(strict_types=1);

namespace Domains\Roles\DataTransfertObjects;

use App\Models\Role;
use Core\Utils\DataTransfertObjects\BaseDTO;

/**
 * Class ***`RoleDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`Role`*** model.
 *
 * @package ***`\Domains\Roles\DataTransfertObjects`***
 */
class RoleDTO extends BaseDTO
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
        return Role::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "roles"           => "required|array|min:1",
            "roles.*"         => ["distinct", "exists:roles,id"]
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
            "roles.required"                => "Le champ roles est requis.",
            "roles.array"                   => "Le champ roles doit être un tableau.",
            "roles.min"                     => "Le champ roles doit contenir au moins un élément.",
            "roles.*.distinct"              => "Les éléments du tableau roles ne doivent pas être en double.",
            "roles.*.exists"                => "Les éléments du tableau roles doivent correspondre à des identifiants valides de rôles."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}