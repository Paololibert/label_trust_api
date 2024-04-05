<?php

declare(strict_types = 1);

namespace App\Http\Requests\Articles\CategorieArticle\v1;

use Core\Utils\Requests\CreateResourceRequest;
use Domains\Articles\CategorieArticle\DataTransfertObjects\CreateCategorieArticleDTO;

/**
 * Class **`CreateCategorieArticleRequest`**
 *
 * Represents a form request for creating a CategorieArticle. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Articles\CategorieArticle\v1`**
 */
class CreateCategorieArticleRequest extends CreateResourceRequest
{

    public function __construct(){
        parent::__construct(CreateCategorieArticleDTO::fromRequest(request()));
        
    }

    /**
     * Determine if the Article is authorized to make this request.
     */
    public function isAuthorize(): bool
    {
        return true;
    }

    /**
     * Authorize the Article to perform the resource creation operation.
     *
     * This method is called during the authorization phase of the request lifecycle.
     * It sets the Data Transfer Object (DTO) associated with this request and then checks the concrete class's authorization.
     *
     * @return bool Whether the Article is authorized.
     */
    public function authorize(): bool
    {
        return parent::authorize();
    }

}
