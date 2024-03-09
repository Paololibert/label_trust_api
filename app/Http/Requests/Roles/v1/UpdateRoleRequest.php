<?php

declare(strict_types = 1);

namespace App\Http\Requests\Roles\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Roles\DataTransfertObjects\UpdateRoleDTO;

/**
 * Class **`UpdateRoleRequest`**
 *
 * Represents a form request for creating a role. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Roles\v1`**
 */
class UpdateRoleRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateRoleDTO::fromRequest(request()), 'role');
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
