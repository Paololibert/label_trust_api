<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Core\Utils\Requests\UpdateResourceRequest;
use Illuminate\Http\Request;

/**
 * Class **`ResourceRequest`**
 *
 * Represents a form request for creating/updating an resource. This class extends UpdateResourceRequest which also extends another ResourceRequest the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests`**
 */
class ResourceRequest extends UpdateResourceRequest
{
    /**
     * ResourceRequest constructor.
     *
     * @param \Core\Utils\DataTransfertObjects\DTOInterface $dto The Data Transfer Object (DTO) instance to associate with this request.
     */
    public function __construct(\Core\Utils\DataTransfertObjects\DTOInterface $dto, string $resouce = null, array $rules = [], array $data = [], Request $request = null)
    {
        parent::__construct($dto::fromRequest(request: $request ?? request(), data: $data, rules: $rules));
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function isAuthorize(): bool
    {
        return true;
    }

    /**
     * Authorize the user to perform the resource creation operation.
     *
     * This method is called during the authorization phase of the request lifecycle.
     * It sets the Data Transfer Object (DTO) associated with this request and then checks the concrete class's authorization.
     *
     * @return bool Whether the user is authorized.
     */
    public function authorize(): bool
    {
        // Check the concrete class's authorization.
        return $this->isAuthorize();
    }
}
