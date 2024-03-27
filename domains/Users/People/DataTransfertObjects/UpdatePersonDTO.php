<?php

declare(strict_types=1);

namespace Domains\Users\People\DataTransfertObjects;

use App\Models\Person;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\Users\MaritalStatusEnum;
use Core\Utils\Enums\Users\SexEnum;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`UpdatePersonDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Person`*** model.
 *
 * @package ***`\Domains\Users\People\DataTransfertObjects`***
 */
class UpdatePersonDTO extends BaseDTO
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
        return Person::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "last_name"             => ["sometimes", "string", 'min:3', 'max:50'],
            "first_name"            => ["sometimes", "string", 'min:3', 'max:30'],
            "middle_name"           => ["sometimes", "array", 'min:1'],
            "middle_name.*"         => ["sometimes", "string", 'min:3', 'max:25'],
            'nip'                   => ['sometimes', 'integer', 'digits:13', 'unique:persons,nip'],
            'ifu'                   => ['sometimes', 'integer', 'digits:13', 'unique:persons,ifu'],
            'sex'                   => ['required', "string", new Enum(SexEnum::class)],
            'marital_status'        => ['sometimes', "string", new Enum(MaritalStatusEnum::class)],
            "birth_date"            => ["sometimes", "datetime", 'Y-m-d', 'date_format:Y-m-d', 'before:today', 'max_age'],
            "nationality"           => ["sometimes", "string", 'max:255'],
            'can_be_deleted'        => ['sometimes', 'boolean', 'in:' . true . ',' . false]
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
            "last_name.required"        => "Le nom de famille est requis.",
            "last_name.string"          => "Le nom de famille doit être une chaîne de caractères.",
            "last_name.min"             => "Le nom de famille doit comporter au moins :min caractères.",
            "last_name.max"             => "Le nom de famille ne peut pas dépasser :max caractères.",
            "first_name.required"       => "Le prénom est requis.",
            "first_name.string"         => "Le prénom doit être une chaîne de caractères.",
            "first_name.min"            => "Le prénom doit comporter au moins :min caractères.",
            "first_name.max"            => "Le prénom ne peut pas dépasser :max caractères.",
            "middle_name.*.string"      => "Le deuxième prénom doit être une chaîne de caractères.",
            "middle_name.*.min"         => "Le deuxième prénom doit comporter au moins :min caractères.",
            "middle_name.*.max"         => "Le deuxième prénom ne peut pas dépasser :max caractères.",
            "nip.integer"               => "Le NIP doit être un entier.",
            "nip.digits"                => "Le NIP doit comporter exactement :digits chiffres.",
            "nip.unique"                => "Ce NIP est déjà utilisé.",
            "ifu.integer"               => "L'IFU doit être un entier.",
            "ifu.digits"                => "L'IFU doit comporter exactement :digits chiffres.",
            "ifu.unique"                => "Cet IFU est déjà utilisé.",
            "sex.required"              => "Le sexe est requis.",
            "sex.string"                => "Le sexe doit être une chaîne de caractères.",
            "sex.enum"                  => "Le sexe doit être l'une des valeurs prédéfinies.",
            "marital_status.string"     => "Le statut matrimonial doit être une chaîne de caractères.",
            "marital_status.enum"       => "Le statut matrimonial doit être l'une des valeurs prédéfinies.",
            "birth_date.datetime"       => "La date de naissance doit être une date valide.",
            "birth_date.date_format"    => "La date de naissance doit être au format :format.",
            "birth_date.before"         => "La date de naissance doit être antérieure à aujourd'hui.",
            "birth_date.max_age"        => "La date de naissance ne peut pas être supérieure à :max_age ans.",
            "nationality.string"        => "La nationalité doit être une chaîne de caractères.",
            "nationality.max"           => "La nationalité ne peut pas dépasser :max caractères.",
            "can_be_deleted.boolean"    => "Le champ peut être supprimé doit être un booléen.",
            "can_be_deleted.in"         => "Le champ peut être supprimé doit être 'true' ou 'false'."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}
