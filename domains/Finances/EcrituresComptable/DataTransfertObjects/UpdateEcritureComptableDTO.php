<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\DataTransfertObjects;

use App\Models\Finances\EcritureComptable;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Domains\Finances\EcrituresComptable\LignesEcritureComptable\DataTransfertObjects\UpdateLigneEcritureComptableDTO;

/**
 * Class ***`UpdateEcritureComptableDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`EcritureComptable`*** model.
 *
 * @package ***`\Domains\Finances\EcrituresComptable\DataTransfertObjects`***
 */
class UpdateEcritureComptableDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();
        $this->merge(new UpdateLigneEcritureComptableDTO('ecritures_comptable'), 'lignes_ecriture', ['array', 'min:2']);
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
            "libelle"                   => ["sometimes", "string", "max:25"],
            "total_debit"               => ["sometimes", "numeric", 'regex:/^0|[1-9]\d+$/'],
            "total_credit"              => ["sometimes", "numeric", 'regex:/^0|[1-9]\d+$/'],
            "date_ecriture"             => ["sometimes", "date", 'date_format:d/m/y'],
            "exercice_comptable_id"     => ["sometimes", "exists:periodes_exercice,id"],
            "journal_id"                => ["sometimes", "exists:journaux,id"],
            'can_be_deleted'        => ['sometimes', 'boolean', 'in:'.true.','.false],
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