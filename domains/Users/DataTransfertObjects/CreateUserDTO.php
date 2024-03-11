<?php

declare(strict_types=1);

namespace Domains\Users\DataTransfertObjects;

use App\Models\User;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\Users\TypeOfAccountEnum;
use Core\Utils\Rules\PhoneNumberRule;
use Domains\Users\Companies\DataTransfertObjects\CreateCompanyDTO;
use Domains\Users\People\DataTransfertObjects\CreatePersonDTO;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`CreateUserDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`User`*** model.
 *
 * @package ***`\Domains\Users\DataTransfertObjects`***
 */
class CreateUserDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();

        if(request('type_of_account')){
            switch (request()->type_of_account) {
                case TypeOfAccountEnum::MORAL->value:
                    $this->merge(new CreateCompanyDTO, 'user', ["required", "array"]);
                    break;                
                default:
                    $this->merge(new CreatePersonDTO, 'user', ["required", "array"]);
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
            'username'              => ['sometimes', 'string', 'min:6', 'max:30', 'unique:users,username'],
            'login_channel'         => ['required', 'string', 'in:email,phone_number'],
            'email'                 => ['required_if:login_channel,email', 'email', 'max:120', 'unique:users,email'],
            'phone_number'          => ['required_if:login_channel,phone_number', new PhoneNumberRule()],
            'role_id'               => 'required|exists:roles,id',
			"address"     		    => ["string", "sometimes"]
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