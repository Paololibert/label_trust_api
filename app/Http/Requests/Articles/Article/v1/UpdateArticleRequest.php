<?php

declare(strict_types = 1);

namespace App\Http\Requests\Articles\Article\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Articles\Article\DataTransfertObjects\UpdateArticleDTO;

/**
 * Class **`UpdateArticleRequest`**
 *
 * Represents a form request for creating a Article. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Articles\Article\v1`**
 */
class UpdateArticleRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateArticleDTO::fromRequest(request()), 'magasin');
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
