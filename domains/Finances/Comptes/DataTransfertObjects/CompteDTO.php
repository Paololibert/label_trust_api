<?php

declare(strict_types=1);

namespace Domains\Finances\Comptes\DataTransfertObjects;

use App\Models\Finances\Compte;
use Core\Utils\DataTransfertObjects\BaseDTO;


/**
 * Class ***`CompteDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`Compte`*** model.
 *
 * @package ***`\Domains\Comptes\DataTransfertObjects`***
 */
class CompteDTO extends BaseDTO
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
        return Compte::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "comptes"           => "required|array|min:1",
            "comptes.*"         => ["distinct", "exists:comptes,id"]
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
            "comptes.required"      => "La liste des comptes est requise.",
            "comptes.array"         => "La liste des comptes doit être un tableau.",
            "comptes.min"           => "La liste des comptes doit contenir au moins un élément.",
            "comptes.*.distinct"    => "La liste des comptes ne doit pas contenir de doublons.",
            "comptes.*.exists"      => "Un ou plusieurs comptes sélectionnés sont invalides."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}