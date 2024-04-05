<?php

declare(strict_types=1);

namespace Domains\Finances\Comptes\DataTransfertObjects;

use App\Models\Finances\Compte;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\TypeCompteEnum;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`UpdateCompteDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Compte`*** model.
 *
 * @package ***`\Domains\Finances\Comptes\DataTransfertObjects`***
 */
class UpdateCompteDTO extends BaseDTO
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
            "type_de_compte"            => ["sometimes", "string", new Enum(TypeCompteEnum::class)],
            "name"            		    => ["required", "string", "max:120", "unique_ignore_case:comptes,name," . request()->route("compte_id") . ",id"],
            "categorie_de_compte_id"    => ["required", "exists:categories_de_compte,id"],
            "can_be_deleted"            => ["sometimes", "boolean", "in:".true.",".false],
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
            "type_de_compte.required"             => "Le type de compte est requis.",
            "type_de_compte.string"               => "Le type de compte doit être une chaîne de caractères.",
            "type_de_compte.enum"                 => "Le type de compte n'est pas valide.",
        
            "name.string"                         => "Le nom du compte doit être une chaîne de caractères.",
            "name.required"                       => "Le nom du compte est requis.",
            "name.max"                            => "Le nom du compte ne peut pas dépasser :max caractères.",
            "name.unique_ignore_case"             => "Ce nom de compte est déjà utilisé.",
        
            "categorie_de_compte_id.required"     => "La catégorie de compte est requise.",
            "categorie_de_compte_id.exists"       => "La catégorie de compte sélectionnée n'existe pas.",
        
            "can_be_deleted.boolean"              => "Le champ indiquant si le compte peut être supprimé doit être un booléen.",
            "can_be_deleted.in"                   => "Le champ indiquant si le compte peut être supprimé doit être 'true' ou 'false'."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}