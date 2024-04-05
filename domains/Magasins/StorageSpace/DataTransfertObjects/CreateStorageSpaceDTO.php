<?php

declare(strict_types=1);

namespace Domains\Magasins\StorageSpace\DataTransfertObjects;

use App\Models\Magasins\StorageSpace;
use Core\Utils\DataTransfertObjects\BaseDTO;


/**
 * Class ***`CreateStorageSpaceDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`StorageSpace`*** model.
 *
 * @package ***`\Domains\Magasins\StorageSpace\DataTransfertObjects`***
 */
class CreateStorageSpaceDTO extends BaseDTO
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
        return StorageSpace::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        
        $rules = array_merge([
            "name"            		=> ["string",  "required",      'unique:storage_spaces,name'],
            "code"                  => ["string", "required",       'unique:storage_spaces,code'],
            "magasin_id"            => ["string",  "required",      "exists:magasins,id"],
            'can_be_deleted'        => ['sometimes', 'boolean',     'in:'.true.','.false],
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
            'can_be_deleted.boolean' => 'Le champ can_be_deleted doit être un booléen.',
            'can_be_deleted.in'      => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}