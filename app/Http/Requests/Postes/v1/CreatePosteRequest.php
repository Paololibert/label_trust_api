<?php

declare(strict_types = 1);

namespace App\Http\Requests\Postes\v1;

use Core\Utils\Requests\CreateResourceRequest;
use Domains\Postes\DataTransfertObjects\CreatePosteDTO;

/**
 * Class **`CreatePosteRequest`**
 *
 * Represents a form request for creating a departement. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Postes\v1`**
 */
class CreatePosteRequest extends CreateResourceRequest
{

    public function __construct(){
        parent::__construct(CreatePosteDTO::fromRequest(request()));
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
