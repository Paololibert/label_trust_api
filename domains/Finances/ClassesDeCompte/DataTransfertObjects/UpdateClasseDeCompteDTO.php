<?php

declare(strict_types=1);

namespace Domains\Finances\ClassesDeCompte\DataTransfertObjects;

use App\Models\Finances\ClasseDeCompte;
use Core\Utils\DataTransfertObjects\BaseDTO;

/**
 * Class ***`UpdateClasseDeCompteDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`ClasseDeCompte`*** model.
 *
 * @package ***`\Domains\Finances\ClassesDeCompte\DataTransfertObjects`***
 */
class UpdateClasseDeCompteDTO extends BaseDTO
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
        return ClasseDeCompte::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "name"            		=> ["string", "required", "max:25", 'unique_ignore_case:classes_de_compte,name,' . request()->route("classe_de_compte_id") . ',id'],
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
            'name.string'                          => 'Le nom de la classe de compte doit être une chaîne de caractères.',
            'name.required'                        => 'Le nom de la classe de compte est requis.',
            'name.max'                             => 'Le nom de la classe de compte ne peut pas dépasser :max caractères.',
            'name.unique_ignore_case'              => 'Le nom de la classe de compte doit être unique, en ignorant la casse.',
            'can_be_deleted.boolean'               => 'Le champ indiquant si la classe de compte peut être supprimée doit être un booléen.',
            'can_be_deleted.in'                    => 'Le champ indiquant si la classe de compte peut être supprimée doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}