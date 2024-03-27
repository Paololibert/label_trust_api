<?php

declare(strict_types=1);

namespace Domains\Finances\Devises\DataTransfertObjects;

use App\Models\Finances\Devise;
use Core\Utils\DataTransfertObjects\BaseDTO;


/**
 * Class ***`CreateDeviseDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`Devise`*** model.
 *
 * @package ***`\Domains\Finances\Devises\DataTransfertObjects`***
 */
class CreateDeviseDTO extends BaseDTO
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
        return Devise::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "name"            		=> ["string", "required", "max:25", 'unique_ignore_case:devises,name'],
            "symbol"            	=> ["string", "required", "max:25", 'unique_ignore_case:devises,symbol'],
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
            "name.required"             => "Le nom de la devise est requis.",
            "name.string"               => "Le nom de la devise doit être une chaîne de caractères.",
            "name.max"                  => "Le nom de la devise ne peut pas dépasser :max caractères.",
            "name.unique_ignore_case"   => "Ce nom de devise est déjà utilisé.",
            "symbol.required"           => "Le symbole de la devise est requis.",
            "symbol.string"             => "Le symbole de la devise doit être une chaîne de caractères.",
            "symbol.max"                => "Le symbole de la devise ne peut pas dépasser :max caractères.",
            "symbol.unique_ignore_case" => "Ce symbole de devise est déjà utilisé.",
            "can_be_deleted.boolean"    => "La devise peut être supprimé et la devise doit être un booléen.",
            "can_be_deleted.in"         => "a devise peut être supprimé et la devise doit être 'true' ou 'false'."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}