<?php

declare(strict_types=1);

namespace Domains\Magasins\ArticleIqp\DataTransfertObjects;

use App\Models\Magasins\ArticleIqp;
use Core\Utils\DataTransfertObjects\BaseDTO;
use Illuminate\Validation\Rules\Enum;

/**
 * Class ***`CreateArticleIqpDTO`***
 *
 * This class extends the ***`BaseDTO`*** class.
 * It represents the data transfer object for creating a new ***`ArticleIqp`*** model.
 *
 * @package ***`\Domains\Magasins\ArticleIqp\DataTransfertObjects`***
 */
class CreateArticleIqpDTO extends BaseDTO
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
        return ArticleIqp::class;
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        $rules = array_merge([
            "name"            		        => ["string", "required", 'unique:article_iqps,name'],
            "norme"                         => ["required", "string"],
            "quantity_treated"              => ["required", "string"],
            'unite_mesure_id'               => ['required', 'string', 'exists:unite_mesures,id'],
            'article_id'                    => ['required', 'string', 'exists:articles,id'],
            'iqp_id'                        => ['required', 'string', 'exists:iqps,id'],
            'can_be_deleted'                => ['sometimes', 'boolean', 'in:'.true.','.false],
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