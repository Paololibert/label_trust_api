<?php

declare(strict_types=1);

namespace Domains\Users\DataTransfertObjects;

use App\Models\User;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\Users\TypeOfAccountEnum;
use Core\Utils\Rules\PhoneNumberRule;
use Domains\Users\Companies\DataTransfertObjects\UpdateCompanyDTO;
use Domains\Users\People\DataTransfertObjects\UpdatePersonDTO;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`UpdateUserDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Role`*** model.
 *
 * @package ***`\Domains\Roles\DataTransfertObjects`***
 */
class UpdateUserDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();

        if(request('type_of_account')){
            switch (request()->type_of_account) {
                case TypeOfAccountEnum::MORAL->value:
                    $this->merge(new UpdateCompanyDTO, 'user', ["sometimes", "array"]);
                    break;                
                default:
                    $this->merge(new UpdatePersonDTO, 'user', ["sometimes", "array"]);
                    break;
            }
        }
    }
    
    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return User::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {

        $rules = array_merge([
            'type_of_account'       => ['required', "string", new Enum(TypeOfAccountEnum::class)],
            'username'              => ['sometimes', 'string', 'min:6', 'max:30', 'unique:users,username,' . request()->route('user_id') . ',id'],
            'email'                 => ['sometimes', 'email', 'max:120', 'unique:users,email'. request()->route('user_id') . ',id' ],
			"address"     		    => ["string", "sometimes"],
            'phone_number'          => ['sometimes', new PhoneNumberRule(), 'unique:users,phone_number,'. request()->route('user_id') . ',id'],
            'role_id'               => 'required|exists:roles,id'
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