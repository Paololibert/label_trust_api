<?php

declare(strict_types = 1);

namespace App\Http\Requests\Finances\v1\Devises;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Finances\Devises\DataTransfertObjects\UpdateDeviseDTO;

/**
 * Class **`UpdateDeviseRequest`**
 *
 * Represents a form request for creating a departement. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Devises\v1`**
 */
class UpdateDeviseRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateDeviseDTO::fromRequest(request()), 'devise');
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
