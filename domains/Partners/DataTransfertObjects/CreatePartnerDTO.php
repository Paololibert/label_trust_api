<?php

declare(strict_types=1);

namespace Domains\Partners\DataTransfertObjects;

use App\Models\Partner;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\TypePartnerEnum;
use Domains\Partners\Clients\DataTransfertObjects\CreateClientDTO;
use Domains\Partners\Suppliers\DataTransfertObjects\CreateSupplierDTO;
use Domains\Users\DataTransfertObjects\CreateUserDTO;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`CreatePartnerDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`Partner`*** model.
 *
 * @package ***`\Domains\Partners\DataTransfertObjects`***
 */
class CreatePartnerDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();
        
        if(request('type_partner')){
            switch (request()->type_partner) {
                case TypePartnerEnum::CLIENT->value:
                    $this->merge(new CreateClientDTO, 'data', ["required", "array"]);
                    break;                
                default:
                    $this->merge(new CreateSupplierDTO, 'data', ["required", "array"]);
                    break;
            }
        }
        
        $this->merge(new CreateUserDTO, 'user', ["required", "array"]);
    }

    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return Partner::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            'company'             => ['sometimes',"string"],
            'country'             => ['sometimes',"string"],
            "type_partner"          => ['required', "string", new Enum(TypePartnerEnum::class)],
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
            'can_be_deleted.boolean' => 'Le champ can_be_deleted doit être un booléen.',
            'can_be_deleted.in'      => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}