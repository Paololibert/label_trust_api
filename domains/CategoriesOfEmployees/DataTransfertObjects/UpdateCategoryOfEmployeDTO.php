<?php

declare(strict_types=1);

namespace Domains\CategoriesOfEmployees\DataTransfertObjects;

use App\Models\CategoryOfEmploye;
use Core\Utils\DataTransfertObjects\BaseDTO;


/**
 * Class ***`UpdateCategoryOfEmployeDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`CategoryOfEmploye`*** model.
 *
 * @package ***`\Domains\CategoriesOfEmployees\DataTransfertObjects`***
 */
class UpdateCategoryOfEmployeDTO extends BaseDTO
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
        return CategoryOfEmploye::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "name"            	  => ["string", "required", 'unique:categories_of_employees,name,' . $this->ignoreValues['categories_of_employee'] . ',id'],
            "department_id"       => ["sometimes",'exists:departements,id'],
            //"category_id"         => ["sometimes",'exists:categories_of_employees,id'],
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
            'can_be_delete.boolean' => 'Le champ can_be_delete doit être un booléen.',
            'can_be_delete.in'      => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}