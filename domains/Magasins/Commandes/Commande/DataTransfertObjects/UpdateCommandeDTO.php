<?php

declare(strict_types=1);

namespace Domains\Magasins\Commandes\Commande\DataTransfertObjects;

use App\Models\Magasins\Commande;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Core\Utils\Enums\StatutsOrderEnum;
use Core\Utils\Enums\TypeOrderEnum;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`UpdateCommandeDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Commande`*** model.
 *
 * @package ***`\Domains\Magasins\Commande\DataTransfertObjects`***
 */
class UpdateCommandeDTO extends BaseDTO
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
        return Commande::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "date"            		            => ["date", "sometimes"],
            "statut"                            => ["sometimes", "string", new Enum(StatutsOrderEnum::class)],
            "type_order"                        => ["sometimes", "string", new Enum(TypeOrderEnum::class)],
            'client_id'                         => ["present_if:supplier_id,null","sometimes", 'uuid', 'exists:clients,id'],
            'supplier_id'                       => ["present_if:client_id,null",'sometimes', 'uuid', 'exists:suppliers,id'],
            'can_be_deleted'                    => ['sometimes', 'boolean', 'in:'.true.','.false],
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