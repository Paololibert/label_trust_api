<?php

declare(strict_types = 1);

namespace App\Http\Requests\Users\v1;

use Core\Utils\Requests\CreateResourceRequest;
use Domains\Users\DataTransfertObjects\CreateUserDTO;

/**
 * Class **`CreateUserRequest`**
 *
 * Represents a form request for creating a user. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Users\v1`**
 */
class CreateUserRequest extends CreateResourceRequest
{

    public function __construct(){
        parent::__construct(CreateUserDTO::fromRequest(request()));
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function isAuthorize(): bool
    {
        return true;
    }

    /**
     * Authorize the user to perform the resource creation operation.
     *
     * This method is called during the authorization phase of the request lifecycle.
     * It sets the Data Transfer Object (DTO) associated with this request and then checks the concrete class's authorization.
     *
     * @return bool Whether the user is authorized.
     */
    public function authorize(): bool
    {
        return parent::authorize();
    }
}
