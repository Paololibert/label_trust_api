<?php

declare(strict_types = 1);

namespace App\Http\Requests\Magasins\ArticleIqp\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Magasins\ArticleIqp\DataTransfertObjects\UpdateArticleIqpDTO;

/**
 * Class **`UpdateArticleIqpRequest`**
 *
 * Represents a form request for creating a ArticleIqp. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Magasins\ArticleIqp\v1`**
 */
class UpdateArticleIqpRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateArticleIqpDTO::fromRequest(request()), 'article_iqp');
    }

    /**
     * Determine if the ArticleIqp is authorized to make this request.
     */
    public function isAuthorize(): bool
    {
        return true;
    }
    
    public function authorize(): bool
    {
        return parent::authorize();
    }

}
