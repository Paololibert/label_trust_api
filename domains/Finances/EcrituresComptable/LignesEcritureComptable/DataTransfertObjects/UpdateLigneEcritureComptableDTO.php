<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\LignesEcritureComptable\DataTransfertObjects;

use App\Models\Finances\LigneEcritureComptable;
use App\Rules\AccountNumberExistsInEitherTable;
use App\Rules\EquilibreEcritureComptable;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\TypeEcritureCompteEnum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`UpdateLigneEcritureComptableDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`LigneEcritureComptable`*** model.
 *
 * @package ***`\Domains\Finances\EcrituresComptable\LignesEcritureComptable\DataTransfertObjects`***
 */
class UpdateLigneEcritureComptableDTO extends BaseDTO
{

    /**
     * @var string
     */
    protected $ligneableRule;

    public function __construct(string $ligneableRule)
    {
        parent::__construct();

        $this->$ligneableRule = $ligneableRule;
    }
    
    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return LigneEcritureComptable::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "lignes_ecriture"                           => ["required", "array", "min:2", new EquilibreEcritureComptable()],
            "lignes_ecriture.*"                         => ["distinct", "array"],
            'lignes_ecriture.*.id'                      => ['sometimes', "string", Rule::exists("lignes_ecriture_comptable", "id")->where("ligneable_id", request()->route("operationComptableId") )],
            'lignes_ecriture.*.type_ecriture_compte'    => ['required', "string", new Enum(TypeEcritureCompteEnum::class)],
            "lignes_ecriture.*.montant"                 => ["required", "numeric", 'regex:/^0|[1-9]\d+$/'],
            "lignes_ecriture.*.account_number"          => ["required", "distinct", new AccountNumberExistsInEitherTable()],
            'can_be_deleted'                            => ['sometimes', 'boolean', 'in:'.true.','.false],
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