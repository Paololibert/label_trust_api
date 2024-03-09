<?php

declare(strict_types = 1);

namespace App\Http\Requests\UniteMesures\v1;

use Core\Utils\Requests\CreateResourceRequest;
use Domains\UniteMesures\DataTransfertObjects\CreateUniteMesureDTO;

/**
 * Class **`CreateUniteMesureRequest`**
 *
 * Represents a form request for creating a unite_travaille. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\UniteMesures\v1`**
 */
class CreateUniteMesureRequest extends CreateResourceRequest
{

    public function __construct(){
        parent::__construct(CreateUniteMesureDTO::fromRequest(request()));
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
