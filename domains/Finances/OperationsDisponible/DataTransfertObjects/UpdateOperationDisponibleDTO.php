<?php

declare(strict_types=1);

namespace Domains\Finances\OperationsDisponible\DataTransfertObjects;

use App\Models\Finances\ExerciceComptable;
use App\Models\Finances\OperationComptableDisponible;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\StatusExerciceEnum;
use Domains\Finances\EcrituresComptable\LignesEcritureComptable\DataTransfertObjects\UpdateLigneEcritureComptableDTO;
use Illuminate\Validation\ValidationException;

/**
 * Class ***`UpdateOperationDisponibleDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`OperationDisponible`*** model.
 *
 * @package ***`\Domains\Finances\OperationsDisponible\DataTransfertObjects`***
 */
class UpdateOperationDisponibleDTO extends BaseDTO
{

    /**
     * @var
     */
    protected $exercice_comptable;

    public function __construct()
    {
        parent::__construct();

        $this->exercice_comptable = ExerciceComptable::find(request()->route("exercice_comptable_id"));

        if (!$this->exercice_comptable) {
            throw ValidationException::withMessages(["Exercice comptable inconnu"]);
        } else {
            if ($this->exercice_comptable->status_exercice === StatusExerciceEnum::CLOSE) {
                throw ValidationException::withMessages(["L'exercice comptable est deja cloturer"]);
            }
        }

        $this->merge(new UpdateLigneEcritureComptableDTO('operations_comptable'));
    }
    
    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return OperationComptableDisponible::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $periode = $this->exercice_comptable?->periode_exercice;

        $rules = array_merge([
            "libelle"                   => ["required", "string", "max:25"],
            "date_ecriture"             => ["required", 'date_format:Y-m-d', "after_or_equal:" . $periode?->date_debut_periode . "/{$this->exercice_comptable?->fiscal_year}", 'before_or_equal:' . $periode?->date_fin_periode . "/{$this->exercice_comptable?->fiscal_year}"],
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
            'can_be_delete.boolean' => 'Le champ can_be_delete doit être un booléen.',
            'can_be_delete.in'      => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}