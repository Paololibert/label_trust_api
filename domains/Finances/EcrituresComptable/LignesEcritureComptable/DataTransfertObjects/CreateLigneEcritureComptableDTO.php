<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\LignesEcritureComptable\DataTransfertObjects;

use App\Models\Finances\LigneEcritureComptable;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\TypeEcritureCompteEnum;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`CreateLigneEcritureComptableDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`LigneEcritureComptable`*** model.
 *
 * @package ***`\Domains\Finances\EcrituresComptable\LignesEcritureComptable\DataTransfertObjects`***
 */
class CreateLigneEcritureComptableDTO extends BaseDTO
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
        // 'libelle', 'montant', 'type_ecriture_compte', 'ligneable_id', 'ligneable_type', 'accountable_id', 'accountable_type'
        $rules = array_merge([
            'type_ecriture_compte'      => ['required', "string", new Enum(TypeEcritureCompteEnum::class)],
            "montant"                   => ["required", "numeric", 'regex:/^0|[1-9]\d+$/'],
            "ligneable_id"              => ["required", "exists:".$this->ligneableRule],
            "compte_id"                 => ["required", "exists:comptes,id"],
            'can_be_deleted'            => ['sometimes', 'boolean', 'in:'.true.','.false],
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
            'can_be_deleted.boolean' => 'Le champ can_be_deleted doit être un booléen.',
            'can_be_deleted.in'      => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}