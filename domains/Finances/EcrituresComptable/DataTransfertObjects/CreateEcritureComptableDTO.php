<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\DataTransfertObjects;

use App\Models\Finances\EcritureComptable;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Domains\Finances\EcrituresComptable\LignesEcritureComptable\DataTransfertObjects\CreateLigneEcritureComptableDTO;

/**
 * Class ***`CreateEcritureComptableDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`EcritureComptable`*** model.
 *
 * @package ***`\Domains\Finances\EcrituresComptable\DataTransfertObjects`***
 */
class CreateEcritureComptableDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();
        $this->merge(new CreateLigneEcritureComptableDTO('ecritures_comptable'), 'lignes_ecriture', ['array', 'min:2']);
    }

    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return EcritureComptable::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "libelle"                   => ["required", "string", "max:25"],
            "total_debit"               => ["required", "numeric", 'regex:/^0|[1-9]\d+$/'],
            "total_credit"              => ["required", "numeric", 'regex:/^0|[1-9]\d+$/'],
            "date_ecriture"             => ["required", "date", 'date_format:d/m/y'],
            "exercice_comptable_id"     => ["required", "exists:periodes_exercice,id"],
            "journal_id"                => ["required", "exists:journaux,id"],
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