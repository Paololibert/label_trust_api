<?php

declare(strict_types=1);

namespace Domains\Users\People\DataTransfertObjects;

use App\Models\Person;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\Users\MaritalStatusEnum;
use Core\Utils\Enums\Users\SexEnum;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`CreatePersonDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`Person`*** model.
 *
 * @package ***`\Domains\Users\People\DataTransfertObjects`***
 */
class CreatePersonDTO extends BaseDTO
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
			"last_name"             => ["required", "string", 'min:3', 'max:50'],
			"first_name"            => ["required", "string", 'min:3', 'max:30'],
			"middle_name"           => ["sometimes", "array", 'min:1'],
			"middle_name.*"         => ["sometimes", "string", 'min:3', 'max:25'],
            'nip'                   => ['sometimes', 'integer', 'digits:13', 'unique:users,nip'],
            'ifu'                   => ['sometimes', 'integer', 'digits:13', 'unique:users,ifu'],
            'sex'                   => ['required', "string", new Enum(SexEnum::class)],
            'marital_status'        => ['sometimes', "string", new Enum(MaritalStatusEnum::class)],
            "birth_date"            => ["sometimes", "datetime", 'Y-m-d', 'date_format:Y-m-d', 'before:today', 'max_age'],
			"nationality"           => ["sometimes", "string", 'max:255'],
            'can_be_deleted'        => ['sometimes', 'boolean', 'in:'.true.','.false]
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