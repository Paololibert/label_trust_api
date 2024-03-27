<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\DataTransfertObjects;

use App\Models\CategoryOfEmployeeTaux;
use Core\Utils\DataTransfertObjects\BaseDTO;

/**
 * Class ***`UpdateCategoryOfEmployeeTauxDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`CategoryOfEmployeeTaux`*** model.
 *
 * @package ***`\Domains\CategoriesOfEmployees\CategoryOfEmployeeTaux\DataTransfertObjects`***
 */
class UpdateCategoryOfEmployeeTauxDTO extends BaseDTO
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
        return CategoryOfEmployeeTaux::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "taux"                          => ["required", "array"],
            "taux.*"                        => ["distinct", "array", "min:1"],
            'taux.*.est_le_taux_de_base'    => ['boolean', 'in:'.true.','.false],
            "taux.*.taux_id"                => ["required", "exists:taux_and_salaries,id"],
            'taux.*.can_be_deleted'         => ['nullable', 'boolean', 'in:'.true.','.false]
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
            "taux.required"                     => "Le champ taux est requis.",
            "taux.array"                        => "Le champ taux doit être un tableau.",
            "taux.*.distinct"                   => "Les éléments du tableau taux ne doivent pas être en double.",
            "taux.*.min"                        => "Chaque élément du tableau taux doit contenir au moins un élément.",
            "taux.*.est_le_taux_de_base.boolean"=> "Le champ est_le_taux_de_base doit être un booléen.",
            "taux.*.est_le_taux_de_base.in"     => "Le champ est_le_taux_de_base doit être 'true' ou 'false'.",
            "taux.*.taux_id.required"           => "Le champ taux_id est requis.",
            "taux.*.taux_id.exists"             => "Chaque élément du tableau taux doit correspondre à un identifiant valide de taux et salaire.",
            "taux.*.can_be_deleted.boolean"     => "Le champ can_be_deleted doit être un booléen.",
            "taux.*.can_be_deleted.in"          => "Le champ can_be_delete doit être 'true' ou 'false'."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}