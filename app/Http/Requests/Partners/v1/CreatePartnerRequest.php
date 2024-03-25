<?php

declare(strict_types = 1);

namespace App\Http\Requests\Partners\v1;

use Core\Utils\Requests\CreateResourceRequest;
use Domains\Partners\DataTransfertObjects\CreatePartnerDTO;

/**
 * Class **`CreatePartnerRequest`**
 *
 * Represents a form request for creating a Partner. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Partners\v1`**
 */
class CreatePartnerRequest extends CreateResourceRequest
{

    public function __construct(){
        parent::__construct(CreatePartnerDTO::fromRequest(request()));
    }

    /**
     * Determine if the Partner is authorized to make this request.
     */
    public function isAuthorize(): bool
    {
        return true;
    }

    /**
     * Authorize the Partner to perform the resource creation operation.
     *
     * This method is called during the authorization phase of the request lifecycle.
     * It sets the Data Transfer Object (DTO) associated with this request and then checks the concrete class's authorization.
     *
     * @return bool Whether the Partner is authorized.
     */
    public function authorize(): bool
    {
        return parent::authorize();
    }

}
