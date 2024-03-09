<?php

declare(strict_types = 1);

namespace App\Http\Requests\Departements\v1;

use Core\Utils\Requests\CreateResourceRequest;
use Domains\Departements\DataTransfertObjects\CreateDepartementDTO;

/**
 * Class **`CreateDepartementRequest`**
 *
 * Represents a form request for creating a departement. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Departements\v1`**
 */
class CreateDepartementRequest extends CreateResourceRequest
{

    public function __construct(){
        parent::__construct(CreateDepartementDTO::fromRequest(request()));
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