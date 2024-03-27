<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\DataTransfertObjects;

use App\Models\CategoryOfEmployee;
use Core\Utils\DataTransfertObjects\BaseDTO;


/**
 * Class ***`UpdateCategoryOfEmployeeDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`CategoryOfEmployee`*** model.
 *
 * @package ***`\Domains\CategoriesOfEmployees\DataTransfertObjects`***
 */
class UpdateCategoryOfEmployeeDTO extends BaseDTO
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
        return CategoryOfEmployee::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "name"            	  => ["string", "required", 'unique_ignore_case:categories_of_employees,name,' . request()->route("category_of_employee_id"). ',id'],
            'can_be_deleted'      => ['sometimes', 'boolean', 'in:'.true.','.false],
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
            "name.required"             => "Le nom de la catégorie d'employé est requis.",
            "name.string"               => "Le nom de la catégorie d'employé doit être une chaîne de caractères.",
            "name.unique_ignore_case"   => "Le nom de la catégorie d'employé est déjà utilisé.",
            "category_id.exists"        => "La catégorie parente sélectionnée est invalide.",
            'can_be_deleted.boolean'    => "La catégorie peut être supprimé et la valeur doit être un booléen.",
            'can_be_deleted.in'         => "La catégorie peut être supprimé et la valeur doit être 'true' ou 'false'."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}