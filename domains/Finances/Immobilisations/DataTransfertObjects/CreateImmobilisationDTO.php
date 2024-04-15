<?php

declare(strict_types=1);

namespace Domains\Finances\Immobilisations\DataTransfertObjects;

use App\Models\Finances\Immobilisation;
use App\Rules\AccountNumberExistsInEitherTable;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\MethodeImmobilisationEnum;
use Core\Utils\Enums\TypeImmobilisationEnum;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`CreateImmobilisationDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`Immobilisation`*** model.
 *
 * @package ***`\Domains\Finances\Immobilisations\DataTransfertObjects`***
 */
class CreateImmobilisationDTO extends BaseDTO
{
    /**
     * @var
     */
    protected $exercice_comptable;

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
        return Immobilisation::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {

        $rules = array_merge([
            "name"                      => ["required", "string", "max:50"],

            "type_immobilisation"       => ["required", "string", new Enum(TypeImmobilisationEnum::class)],
            "methode_immobilisation"    => ["required", "string", new Enum(MethodeImmobilisationEnum::class)],
            "valeur_origine"            => ["required", "numeric", "regex:/^0|[1-9]\d+$/"],
            "valeur_residuelle"         => ["required", "numeric", "regex:/^0|[1-9]\d+$/"],
            "duree_ammortissement"      => ["required", "integer"],

            "date_acquisition"          => ["required", "date_format:Y-m-d", "before_or_equal:" . today()],

            "date_depreciation"         => ["required", "date_format:Y-m-d", "after_or_equal:date_acquisition"],

            "account_number"            => ["required", "distinct", new AccountNumberExistsInEitherTable()],
            "article_id"                => ["sometimes", "exists:articles,id"],
            "est_prorata_temporis"      => ["sometimes", "boolean"],
            "can_be_deleted"            => ["sometimes", "boolean"],
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
            "name.required"                     => "Le champ nom est requis.",
            "name.string"                       => "Le nom doit être une chaîne de caractères.",
            "name.max"                          => "Le nom ne peut pas dépasser 50 caractères.",

            "type_immobilisation.required"      => "Le type d'immobilisation est requis.",
            "type_immobilisation.string"        => "Le type d'immobilisation doit être une chaîne de caractères.",

            "methode_immobilisation.required"   => "La méthode d'immobilisation est requise.",
            "methode_immobilisation.string"     => "La méthode d'immobilisation doit être une chaîne de caractères.",

            "valeur_origine.required"           => "La valeur d'origine est requise.",
            "valeur_origine.numeric"            => "La valeur d'origine doit être un nombre.",
            "valeur_origine.regex"              => "La valeur d'origine doit être un entier positif.",

            "valeur_residuelle.required"        => "La valeur résiduelle est requise.",
            "valeur_residuelle.numeric"         => "La valeur résiduelle doit être un nombre.",
            "valeur_residuelle.regex"           => "La valeur résiduelle doit être un entier positif.",

            "duree_ammortissement.required"     => "La durée d'amortissement est requise.",
            "duree_ammortissement.integer"      => "La durée d'amortissement doit être un entier.",

            "date_acquisition.required"         => "La date d'acquisition est requise.",
            "date_acquisition.date_format"      => "La date d'acquisition doit être au format Y-m-d.",
            "date_acquisition.before_or_equal" => "La date d'acquisition doit être avant ou égale à aujourd'hui.",

            "date_depreciation.required"        => "La date de dépréciation est requise.",
            "date_depreciation.date_format"     => "La date de dépréciation doit être au format Y-m-d.",
            "date_depreciation.after_or_equal"  => "La date de dépréciation doit être après ou égale à la date d\"acquisition.",

            "account_number.required"           => "Le numéro de compte est requis.",
            "account_number.distinct"           => "Le numéro de compte doit être distinct.",
            "aricle_id.exists"                  => "L'article sélectionné n'existe pas.",

            "est_prorata_temporis.boolean"      => "Le champ 'est pro rata temporis' doit être un booléen.",
            "can_be_deleted.boolean"            => "Le champ 'peut être supprimé' doit être un booléen.",
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}
