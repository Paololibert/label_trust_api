<?php

declare(strict_types=1);

namespace Domains\UniteTravailles\DataTransfertObjects;

use App\Models\UniteTravaille;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\TypeUniteTravailleEnum;
use Domains\TauxAndSalaries\DataTransfertObjects\UpdateTauxAndSalaryDTO;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`UpdateUniteTravailleDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`UniteTravaille`*** model.
 *
 * @package ***`\Domains\UniteTravailles\DataTransfertObjects`***
 */
class UpdateUniteTravailleDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();
        $this->merge(new UpdateTauxAndSalaryDTO, 'taux', ["sometimes", "array"]);
    }
    
    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return UniteTravaille::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "type_of_unite_travaille"   => ['sometimes', "string", new Enum(TypeUniteTravailleEnum::class)],
            "unite_mesure_id"           => ["sometimes",'exists:unite_mesures,id'],
            "article_id"                => ['required_if:type_of_unite_travaille,article', 'exists:articles,id'],
            'can_be_deleted'        => ['sometimes', 'boolean', 'in:'.true.','.false]
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