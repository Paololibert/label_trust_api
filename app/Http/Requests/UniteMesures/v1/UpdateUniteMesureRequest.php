<?php

declare(strict_types = 1);

namespace App\Http\Requests\UniteMesures\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\UniteMesures\DataTransfertObjects\UpdateUniteMesureDTO;

/**
 * Class **`UpdateUniteMesureRequest`**
 *
 * Represents a form request for creating a unite_mesure. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\UniteMesures\v1`**
 */
class UpdateUniteMesureRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateUniteMesureDTO::fromRequest(request()), 'unite_mesure');
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
