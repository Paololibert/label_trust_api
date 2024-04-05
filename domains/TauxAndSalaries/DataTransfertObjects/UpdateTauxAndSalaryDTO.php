<?php

declare(strict_types=1);

namespace Domains\TauxAndSalaries\DataTransfertObjects;

use App\Models\TauxAndSalary;
use Core\Utils\DataTransfertObjects\BaseDTO;

/**
 * Class ***`UpdateTauxAndSalaryDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`TauxAndSalary`*** model.
 *
 * @package ***`\Domains\TauxAndSalaries\DataTransfertObjects`***
 */
class UpdateTauxAndSalaryDTO extends BaseDTO
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
        return TauxAndSalary::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "taux"                      => ["required", "array"],
            "taux.*"                    => ["distinct", "array", "min:2"],
            "taux.*.taux_id"            => ["required", "uuid", "exists:taux_and_salaries,id"],
            "taux.*.rate"               => ["sometimes", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            "taux.*.hint"               => ["sometimes", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            "taux.*.unite_mesure_id"    => ["sometimes", "uuid", "exists:unite_mesures,id"],
            'taux.*.can_be_deleted'     => ['nullable', 'boolean', 'in:' . true . ',' . false]
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

            "taux.required"                 => "Le champ taux est requis.",
            "taux.array"                    => "Le champ taux doit être un tableau.",
            "taux.min"                      => "Le champ taux doit contenir au moins deux éléments.",
            "taux.*.distinct"               => "Les éléments du tableau taux ne doivent pas être en double.",
            "taux.*.taux_id.required"       => "Le champ taux_id de chaque élément de taux est requis.",
            "taux.*.taux_id.uuid"           => "Le champ taux_id de chaque élément de taux doit être un UUID valide.",
            "taux.*.taux_id.exists"         => "Le champ taux_id de chaque élément de taux doit correspondre à un identifiant valide de taux et salaire.",
            "taux.*.rate.numeric"           => "Le champ rate de chaque élément de taux doit être un nombre.",
            "taux.*.rate.regex"             => "Le champ rate de chaque élément de taux doit être au format numérique avec deux décimales au maximum.",
            "taux.*.hint.numeric"           => "Le champ hint de chaque élément de taux doit être un nombre.",
            "taux.*.hint.regex"             => "Le champ hint de chaque élément de taux doit être au format numérique avec deux décimales au maximum.",
            "taux.*.unite_mesure_id.uuid"   => "Le champ unite_mesure_id de chaque élément de taux doit être un UUID valide.",
            "taux.*.unite_mesure_id.exists" => "Le champ unite_mesure_id de chaque élément de taux doit correspondre à un identifiant valide d'unité de mesure.",
            "taux.*.can_be_deleted.boolean" => "Le champ can_be_deleted de chaque élément de taux doit être un booléen.",
            "taux.*.can_be_deleted.in"      => "Le champ can_be_deleted de chaque élément de taux doit être 'true' ou 'false'."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}
