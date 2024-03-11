<?php

declare(strict_types=1);

namespace Domains\UniteTravailles\DataTransfertObjects;

use App\Models\UniteTravaille;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\TypeUniteTravailleEnum;
use Domains\TauxAndSalaries\DataTransfertObjects\CreateTauxAndSalaryDTO;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`CreateUniteTravailleDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`UniteTravaille`*** model.
 *
 * @package ***`\Domains\UniteTravailles\DataTransfertObjects`***
 */
class CreateUniteTravailleDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();
        $this->merge(new CreateTauxAndSalaryDTO);
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
            "type_of_unite_travaille"   => ['required', "string", new Enum(TypeUniteTravailleEnum::class)],
            'unite_mesure_id' => [
                'required',
                Rule::unique('unite_travailles', 'unite_mesure_id')
                    ->where(function ($query) {
                        $query->where('type_of_unite_travaille', request('type_of_unite_travaille'))
                            ->when(request('article_id'), function ($query, $articleId) {
                                return $query->where('article_id', $articleId);
                            });
                    })
            ],

            // Use 'required_if' rule to make 'article_id' required only when 'type_of_unite_travaille' is 'article'
            "article_id"                => ['required_if:type_of_unite_travaille,article', 'exists:articles,id'],
            'can_be_deleted'            => ['sometimes', 'boolean', 'in:'.true.','.false]
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