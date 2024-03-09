<?php

declare(strict_types = 1);

namespace App\Http\Requests\Postes\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Postes\DataTransfertObjects\UpdatePosteDTO;

/**
 * Class **`UpdatePosteRequest`**
 *
 * Represents a form request for creating a departement. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Postes\v1`**
 */
class UpdatePosteRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdatePosteDTO::fromRequest(request()), 'poste');
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
