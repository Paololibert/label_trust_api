<?php

declare(strict_types = 1);

namespace App\Http\Requests\Articles\Article\v1;

use Core\Utils\Requests\CreateResourceRequest;
use Domains\Articles\Article\DataTransfertObjects\CreateArticleDTO;

/**
 * Class **`CreateArticleRequest`**
 *
 * Represents a form request for creating a Article. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Articles\Article\v1`**
 */
class CreateArticleRequest extends CreateResourceRequest
{

    public function __construct(){
        parent::__construct(CreateArticleDTO::fromRequest(request()));
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
        dd($this->dto);
        return parent::authorize();
    }

}
