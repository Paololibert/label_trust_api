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
            'email'                 => ['sometimes', 'email', 'max:120', 'unique:users,email,'. request()->route('user_id') . ',id' ],
			"address"     		    => ["string", "sometimes"],
            'phone_number'          => ['sometimes', new PhoneNumberRule(ignore_value: request()->route('user_id'))],
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
            "type_of_account.required"  => "Le type de compte est requis.",
            "type_of_account.string"    => "Le type de compte doit être une chaîne de caractères.",
            "type_of_account.enum"      => "Le type de compte doit être l'une des valeurs prédéfinies.",
            "username.string"           => "Le nom d'utilisateur doit être une chaîne de caractères.",
            "username.min"              => "Le nom d'utilisateur doit comporter au moins :min caractères.",
            "username.max"              => "Le nom d'utilisateur ne peut pas dépasser :max caractères.",
            "username.unique"           => "Ce nom d'utilisateur est déjà utilisé.",
            "login_channel.required"    => "Le canal de connexion est requis.",
            "login_channel.string"      => "Le canal de connexion doit être une chaîne de caractères.",
            "login_channel.in"          => "Le canal de connexion doit être l'une des valeurs prédéfinies.",
            "email.required_if"         => "L'adresse e-mail est requise lorsque le canal de connexion est l'e-mail.",
            "email.email"               => "L'adresse e-mail doit être une adresse e-mail valide.",
            "email.max"                 => "L'adresse e-mail ne peut pas dépasser :max caractères.",
            "email.unique"              => "Cette adresse e-mail est déjà utilisée.",
            "phone_number.required_if"  => "Le numéro de téléphone est requis lorsque le canal de connexion est le numéro de téléphone.",
            "role_id.required"          => "Le rôle est requis.",
            "role_id.exists"            => "Le rôle sélectionné est invalide.",
            "address.string"            => "L'adresse doit être une chaîne de caractères."
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}