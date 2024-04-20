<?php

declare(strict_types=1);

namespace Domains\Finances\ProjetsProduction\DataTransfertObjects;

use App\Models\Finances\ProjetProduction;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Illuminate\Validation\Rule;

/**
 * Class ***`UpdateProjetProductionDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`ProjetProduction`*** model.
 *
 * @package ***`\Domains\Finances\ProjetsProduction\DataTransfertObjects`***
 */
class UpdateProjetProductionDTO extends BaseDTO
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
        return ProjetProduction::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "intitule"                  => ["required", "string", "unique_ignore_case:projets_production,intitule"],
            "description"               => ["nullable", "string"],
            "date_debut"                => ["required", "date_format:Y-m-d", "after_or_equal:" . today()],
            "date_fin"                  => ["required", "date_format:Y-m-d", "after:date_debut"],
            "ligne_de_production_id"    => ["required", "exists:lignes_de_production,id"],
            "article_id"                => ["required", "exists:articles,id"],
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
            "fiscal_year.required"              => "Le champ année fiscale est requis.",
            "fiscal_year.numeric"               => "Le champ année fiscale doit être numérique.",
            "fiscal_year.regex"                 => "Le champ année fiscale doit être au format valide.",
            "fiscal_year.unique"                => "L'année fiscale spécifiée existe déjà dans la base de données.",
            "periode_exercice_id.required"      => "Le champ période d'exercice est requis.",
            "periode_exercice_id.exists"        => "La période d'exercice spécifiée est invalide.",
            "plan_comptable_id.required"        => "Le champ plan comptable est requis.",
            "plan_comptable_id.exists"          => "Le plan comptable spécifié est invalide.",
            "can_be_deleted.boolean"            => "Le champ peut être supprimé doit être un booléen.",
            "can_be_deleted.in"                 => "La valeur du champ peut être supprimée doit être vrai ou faux."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}