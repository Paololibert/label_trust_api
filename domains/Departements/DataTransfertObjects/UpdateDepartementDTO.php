<?php

declare(strict_types=1);

namespace Domains\Departements\DataTransfertObjects;

use App\Models\Departement;
use Core\Utils\DataTransfertObjects\BaseDTO;


/**
 * Class ***`UpdateDepartementDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Departement`*** model.
 *
 * @package ***`\Domains\Departements\DataTransfertObjects`***
 */
class UpdateDepartementDTO extends BaseDTO
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
        return Departement::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "name"                    => ["string", "required", 'unique_ignore_case:departements,name,' . request()->route("departement_id") . ',id'],
            'can_be_deleted'        => ['sometimes', 'boolean', 'in:' . true . ',' . false],
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
            "name.string"               => "Le nom du département doit être une chaîne de caractères.",
            "name.required"             => "Le nom du département est requis.",
            "name.unique_ignore_case"   => "Le nom du département est déjà utilisé.", // Personnaliser le message pour l"unicité
            "can_be_deleted.boolean"    => "Le champ peut être supprimé doit être un booléen.",
            "can_be_deleted.in"         => "Le champ peut être supprimé doit être 'true' ou 'false'."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}
