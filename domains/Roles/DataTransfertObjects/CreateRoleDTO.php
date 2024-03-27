<?php

declare(strict_types=1);

namespace Domains\Roles\DataTransfertObjects;

use App\Models\Role;
use Core\Utils\DataTransfertObjects\BaseDTO;


/**
 * Class ***`CreateRoleDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`Role`*** model.
 *
 * @package ***`\Domains\Roles\DataTransfertObjects`***
 */
class CreateRoleDTO extends BaseDTO
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
            "name"                  => ["string", "required", 'unique_ignore_case:roles,name'],
            "description"           => ["string", "sometimes"],
            'can_be_deleted'        => ['sometimes', 'boolean', 'in:' . true . ',' . false],
            'permissions'           => 'required|array|min:1',
            'permissions.*'         => ['distinct', "exists:permissions,id"]
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
            "name.string"               => "Le nom du rôle doit être une chaîne de caractères.",
            "name.required"             => "Le nom du rôle est requis.",
            "name.unique_ignore_case"   => "Le nom du rôle est déjà utilisé.", // Message personnalisé pour l"unicité
            "description.string"        => "La description du rôle doit être une chaîne de caractères.",
            "permissions.required"      => "Au moins une permission est requise pour le rôle.",
            "permissions.array"         => "Les permissions doivent être fournies sous forme de tableau.",
            "permissions.min"           => "Le rôle doit avoir au moins une permission assignée.",
            "permissions.*.distinct"    => "Les permissions ne doivent pas être en double.",
            "permissions.*.exists"      => "Une ou plusieurs des permissions sélectionnées sont invalides.", // Message personnalisé pour la validation d'existence
            "can_be_deleted.boolean"    => "Le rôle peut être supprimé doit être un booléen.",
            "can_be_deleted.in"         => "Le rôle peut être supprimé doit être 'true' ou 'false'.",
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}
