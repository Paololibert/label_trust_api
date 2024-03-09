<?php

declare(strict_types=1);

namespace Domains\Users\Companies\DataTransfertObjects;

use App\Models\Company;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Class ***`UpdateCompanyDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for updating a new ***`Company`*** model.
 *
 * @package ***`\Domains\Users\Companies\DataTransfertObjects;`***
 */
class UpdateCompanyDTO extends BaseDTO
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
        return Company::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "name"            		=> ["string", "required"],
			"registration_number"   => ["string", "sometimes", 'unique:companies,registration_number'],
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