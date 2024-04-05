<?php

declare(strict_types=1);

namespace Domains\Postes\DataTransfertObjects;

use App\Models\Poste;
use Core\Utils\DataTransfertObjects\BaseDTO;


/**
 * Class ***`UpdatePosteDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Poste`*** model.
 *
 * @package ***`\Domains\Postes\DataTransfertObjects`***
 */
class UpdatePosteDTO extends BaseDTO
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
        return Poste::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "name"            		=> ["string", "required", 'unique_ignore_case:postes,name,' . request()->route('poste_id') . ',id'],
            "department_id"         => ["sometimes",'exists:departements,id'],
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
            "name.required"             => "Le nom du poste est requis.",
            "name.string"               => "Le nom du poste doit être une chaîne de caractères.",
            "name.unique_ignore_case"   => "Ce nom de poste est déjà utilisé.",
            "department_id.required"    => "Le département est requis.",
            "department_id.exists"      => "Le département sélectionné est invalide.",
            "can_be_deleted.boolean"    => "Le champ can_be_deleted doit être un booléen.",
            "can_be_deleted.in"         => "Le can_be_delete doit être 'true' ou 'false'."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}