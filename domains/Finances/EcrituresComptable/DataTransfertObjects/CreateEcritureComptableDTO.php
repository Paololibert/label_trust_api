<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\DataTransfertObjects;

use App\Models\Finances\EcritureComptable;
use App\Models\Finances\ExerciceComptable;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\StatusExerciceEnum;
use Domains\Finances\EcrituresComptable\LignesEcritureComptable\DataTransfertObjects\CreateLigneEcritureComptableDTO;
use Illuminate\Validation\ValidationException;

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

        $this->merge(new CreateLigneEcritureComptableDTO('ecritures_comptable'));
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

        $periode = $this->exercice_comptable?->periode_exercice;

        $rules = array_merge([
            "libelle"                   => ["required", "string", "max:25"],
            "date_ecriture"             => ["required", 'date_format:Y-m-d', "after_or_equal:" . $periode?->date_debut_periode . "/{$this->exercice_comptable?->fiscal_year}", 'before_or_equal:' . $periode?->date_fin_periode . "/{$this->exercice_comptable?->fiscal_year}"],
            "journal_id"                => ["required", "exists:journaux,id"],
            'can_be_deleted'            => ['sometimes', 'boolean', 'in:' . true . ',' . false],
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
            "libelle.required"              => "Le libellé est requis.",
            "libelle.string"                => "Le libellé doit être une chaîne de caractères.",
            "libelle.max"                   => "Le libellé ne doit pas dépasser :max caractères.",
            "date_ecriture.required"        => "La date d'écriture est requise.",
            "date_ecriture.date_format"     => "La date d'écriture doit être au format :format.",
            "date_ecriture.after_or_equal"  => "La date d'écriture doit être après ou égale à la date de début de période de l'exercice comptable actuel.",
            "date_ecriture.before_or_equal" => "La date d'écriture doit être avant ou égale à la date de fin de période de l'exercice comptable actuel.",
            "journal_id.required"           => "L'identifiant du journal est requis.",
            "journal_id.exists"             => "L'identifiant du journal spécifié est invalide.",
            "can_be_deleted.boolean"        => "Le champ can_be_deleted doit être un booléen.",
            "can_be_deleted.in"             => "La valeur du champ can_be_deleted doit être :values.",
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}
