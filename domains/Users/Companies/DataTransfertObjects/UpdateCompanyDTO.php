<?php

declare(strict_types=1);

namespace Domains\Users\Companies\DataTransfertObjects;

use App\Models\Company;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Class ***`UpdateCompanyDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Company`*** model.
 *
 * @package ***`\Domains\Users\Companies\DataTransfertObjects;`***
 */
class UpdateCompanyDTO extends BaseDTO
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
        return Company::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "name"            		=> ["string", "required", 'unique_ignore_case:companies,name'],
			"registration_number"   => ["string", "nullable", 'unique_ignore_case:companies,registration_number'],
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
            "name.string"                               => "Le nom de l'entreprise doit être une chaîne de caractères.",
            "name.required"                             => "Le nom de l'entreprise est requis.",
            "name.unique_ignore_case"                   => "Le nom de l'entreprise est déjà utilisé.",
            "registration_number.string"                => "Le numéro d'immatriculation doit être une chaîne de caractères.",
            "registration_number.unique_ignore_case"    => "Le numéro d'immatriculation est déjà utilisé.",
            "can_be_deleted.boolean"                    => "Le champ peut être supprimé doit être un booléen.",
            "can_be_deleted.in"                         => "Le champ peut être supprimé doit être 'true' ou 'false'."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}