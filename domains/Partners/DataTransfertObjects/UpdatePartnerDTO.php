<?php

declare(strict_types=1);

namespace Domains\Partners\DataTransfertObjects;

use App\Models\Partner;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\TypePartnerEnum;
use Domains\Partners\Clients\DataTransfertObjects\UpdateClientDTO;
use Domains\Partners\Suppliers\DataTransfertObjects\UpdateSupplierDTO;
use Domains\Users\DataTransfertObjects\UpdateUserDTO;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

/**
 * Class ***`UpdatePartnerDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Partner`*** model.
 *
 * @package ***`\Domains\Partners\DataTransfertObjects`***
 */
class UpdatePartnerDTO extends BaseDTO
{

    public function __construct()
    {
        parent::__construct();
        if (!($id = Partner::find(request()->route("partner_id"))?->user?->id)){
            throw ValidationException::withMessages(["User not found"]);
        }
         
        request()->route()->setParameter('user_id', $id);
        
        $this->merge(new UpdateUserDTO, 'user', ["required", "array"]);
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
            'company'               => ['sometimes',"string"],
            'country'               => ['sometimes',"string"],
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
            'can_be_delete.boolean' => 'Le champ can_be_delete doit être un booléen.',
            'can_be_delete.in'      => 'Le can_be_delete doit être "true" ou "false".'
        ], $messages);

        $messages = array_merge([], $default_messages);

        return $this->messages = parent::messages($messages);
    }
}