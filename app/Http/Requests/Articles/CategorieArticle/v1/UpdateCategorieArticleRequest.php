<?php

declare(strict_types = 1);

namespace App\Http\Requests\Articles\CategorieArticle\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Articles\CategorieArticle\DataTransfertObjects\UpdateCategorieArticleDTO;

/**
 * Class **`UpdateCategorieArticleRequest`**
 *
 * Represents a form request for creating a CategorieArticle. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Articles\CategorieArticle\v1`**
 */
class UpdateCategorieArticleRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateCategorieArticleDTO::fromRequest(request()), 'storage_space');
    }

    /**
     * Determine if the Article is authorized to make this request.
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
