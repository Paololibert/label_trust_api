<?php

declare(strict_types = 1);

namespace App\Http\Requests\UniteTravailles\v1;

use Core\Utils\Requests\CreateResourceRequest;
use Domains\UniteTravailles\DataTransfertObjects\CreateUniteTravailleDTO;

/**
 * Class **`CreateUniteTravailleRequest`**
 *
 * Represents a form request for creating a unite_travaille. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\UniteTravailles\v1`**
 */
class CreateUniteTravailleRequest extends CreateResourceRequest
{

    public function __construct(){
        parent::__construct(CreateUniteTravailleDTO::fromRequest(request()));
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
