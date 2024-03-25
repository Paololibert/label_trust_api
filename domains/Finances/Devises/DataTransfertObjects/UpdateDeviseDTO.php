<?php

declare(strict_types=1);

namespace Domains\Finances\Devises\DataTransfertObjects;

use App\Models\Finances\Devise;
use Core\Utils\DataTransfertObjects\BaseDTO;


/**
 * Class ***`UpdateDeviseDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Devise`*** model.
 *
 * @package ***`\Domains\Finances\Devises\DataTransfertObjects`***
 */
class UpdateDeviseDTO extends BaseDTO
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
            "name"            		=> ["string", "required", "max:25", 'unique:devises,name,' . request()->route("devise_id") . ',id'],
            "symbol"            	=> ["string", "required", "max:25", 'unique:devises,symbol,' . request()->route("devise_id") . ',id'],
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
            'can_be_delete.boolean' => 'Le champ can_be_delete doit être un booléen.',
            'can_be_delete.in'      => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}