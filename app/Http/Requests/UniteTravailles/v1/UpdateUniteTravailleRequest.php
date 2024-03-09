<?php

declare(strict_types = 1);

namespace App\Http\Requests\UniteTravailles\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\UniteTravailles\DataTransfertObjects\UpdateUniteTravailleDTO;

/**
 * Class **`UpdateUniteTravailleRequest`**
 *
 * Represents a form request for creating a unite_travaille. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\UniteTravailles\v1`**
 */
class UpdateUniteTravailleRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateUniteTravailleDTO::fromRequest(request()), 'unite_travaille');
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
