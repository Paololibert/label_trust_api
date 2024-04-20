<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresComptable\LignesEcritureComptable\DataTransfertObjects;

use App\Models\Finances\LigneEcritureComptable;
use App\Rules\AccountNumberExistsInEitherTable;
use App\Rules\EquilibreEcritureComptable;
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
        $rules = array_merge([
            "lignes_ecriture"                          => ["required", "array", "min:2", new EquilibreEcritureComptable()],
            "lignes_ecriture.*"                        => ["distinct", "array"],
            'lignes_ecriture.*.type_ecriture_compte'   => ['required', "string", new Enum(TypeEcritureCompteEnum::class)],
            "lignes_ecriture.*.montant"                => ["required", "numeric", 'regex:/^0|[1-9]\d+$/'],
            "lignes_ecriture.*.account_number"         => ["required", "distinct"/* , new AccountNumberExistsInEitherTable() */],
            'can_be_deleted'                           => ['sometimes', 'boolean', 'in:' . true . ',' . false],
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

            "lignes_ecriture.required"                          => "Les lignes d'écriture sont requises.",
            "lignes_ecriture.array"                             => "Les lignes d'écriture doivent être sous forme de tableau.",
            "lignes_ecriture.min"                               => "Il doit y avoir au moins une ligne d'écriture.",
            "lignes_ecriture.*.distinct"                        => "Les lignes d'écriture ne doivent pas contenir des éléments en double.",
            "lignes_ecriture.*.type_ecriture_compte.required"   => "Le type d'écriture compte est requis.",
            "lignes_ecriture.*.type_ecriture_compte.string"     => "Le type d'écriture compte doit être une chaîne de caractères.",
            "lignes_ecriture.*.type_ecriture_compte.enum"       => "Le type d'écriture compte n'est pas valide.",
            "lignes_ecriture.*.montant.required"                => "Le montant est requis.",
            "lignes_ecriture.*.montant.numeric"                 => "Le montant doit être numérique.",
            "lignes_ecriture.*.montant.regex"                   => "Le montant doit être un entier positif.",
            "lignes_ecriture.*.account_number.required"         => "Le numéro de compte est requis.",
            "lignes_ecriture.*.account_number.exists"           => "Le numéro de compte spécifié n'existe pas.",
            "lignes_ecriture.*.account_number.distinct"         => "Les numéros de compte ne doivent pas être en double.",
            "can_be_deleted.boolean"                            => "Le champ can_be_deleted doit être un booléen.",
            "can_be_deleted.in"                                 => "La valeur du champ can_be_deleted doit être :values."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}
