<?php

declare(strict_types = 1);

namespace App\Http\Requests\Users\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Users\DataTransfertObjects\UpdateUserDTO;

/**
 * Class **`UpdateUserRequest`**
 *
 * Represents a form request for creating a user. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Users\v1`**
 */
class UpdateUserRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateUserDTO::fromRequest(request()), 'user');
    }

    /**
     * Determine if the user is authorized to make this request.
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
