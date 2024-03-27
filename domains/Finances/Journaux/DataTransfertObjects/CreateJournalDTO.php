<?php

declare(strict_types=1);

namespace Domains\Finances\Journaux\DataTransfertObjects;

use App\Models\Finances\Journal;
use Core\Utils\DataTransfertObjects\BaseDTO;


/**
 * Class ***`CreateJournalDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`Journal`*** model.
 *
 * @package ***`\Domains\Finances\Journaux\DataTransfertObjects`***
 */
class CreateJournalDTO extends BaseDTO
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
        return Journal::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "name"            		=> ["string", "required", "max:25", 'unique_ignore_case:journaux,name'],
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
            "name.required"             => "Le nom du journal est requis.",
            "name.string"               => "Le nom du journal doit être une chaîne de caractères.",
            "name.max"                  => "Le nom du journal ne peut pas dépasser :max caractères.",
            "name.unique_ignore_case"   => "Ce nom de journal est déjà utilisé.",
            "can_be_deleted.boolean"    => "Le champ can_be_delete doit être un booléen.",
            "can_be_deleted.in"         => "Le can_be_delete doit être 'true' ou 'false'."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}