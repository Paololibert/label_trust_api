<?php

declare(strict_types = 1);

namespace App\Http\Requests\Magasins\Magasin\v1;

use Core\Utils\Requests\CreateResourceRequest;
use Domains\Magasins\Magasin\DataTransfertObjects\CreateMagasinDTO;

/**
 * Class **`CreateMagasinRequest`**
 *
 * Represents a form request for creating a Magasin. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Magasins\Magasin\v1`**
 */
class CreateMagasinRequest extends CreateResourceRequest
{

    public function __construct(){
        parent::__construct(CreateMagasinDTO::fromRequest(request()));
    }

    /**
     * Determine if the Magasin is authorized to make this request.
     */
    public function isAuthorize(): bool
    {
        return true;
    }

    /**
     * Authorize the Magasin to perform the resource creation operation.
     *
     * This method is called during the authorization phase of the request lifecycle.
     * It sets the Data Transfer Object (DTO) associated with this request and then checks the concrete class's authorization.
     *
     * @return bool Whether the Magasin is authorized.
     */
    public function authorize(): bool
    {
        return parent::authorize();
    }

}
