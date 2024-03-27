<?php

declare(strict_types=1);

namespace Domains\Postes\PosteSalaries\DataTransfertObjects;

use App\Models\PosteSalary;
use Core\Utils\DataTransfertObjects\BaseDTO;


/**
 * Class ***`PosteSalaryDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`PosteSalary`*** model.
 *
 * @package ***`\Domains\Postes\PosteSalaries\DataTransfertObjects`***
 */
class PosteSalaryDTO extends BaseDTO
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
        return PosteSalary::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            'salaries'           => 'required|array|min:1',
            'salaries.*'         => ['distinct', "exists:taux_and_salaries,id"]
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
            'salaries.required'    => 'Le champ salaries est requis.',
            'salaries.array'       => 'Le champ salaries doit être un tableau.',
            'salaries.min'         => 'Le champ salaries doit contenir au moins un élément.',
            'salaries.*.distinct'  => 'Les éléments du tableau salaries ne doivent pas être en double.',
            'salaries.*.exists'    => 'Les éléments du tableau salaries doivent correspondre à des identifiants valides de taux_and_salaries.'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}