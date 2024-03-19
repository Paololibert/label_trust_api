<?php

declare(strict_types = 1);

namespace App\Http\Requests\EmployeeContractuels\v1;

use Core\Utils\Requests\CreateResourceRequest;
use Domains\Employees\EmployeeContractuels\DataTransfertObjects\CreateEmployeeContractuelDTO;

/**
 * Class **`CreateEmployeeRequest`**
 *
 * Represents a form request for creating a Employee. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Employees\v1`**
 */
class CreateEmployeeContractuelRequest extends CreateResourceRequest
{

    public function __construct(){
        parent::__construct(CreateEmployeeContractuelDTO::fromRequest(request()));
    }

    /**
     * Determine if the Employee is authorized to make this request.
     */
    public function isAuthorize(): bool
    {
        return true;
    }

    /**
     * Authorize the Employee to perform the resource creation operation.
     *
     * This method is called during the authorization phase of the request lifecycle.
     * It sets the Data Transfer Object (DTO) associated with this request and then checks the concrete class's authorization.
     *
     * @return bool Whether the Employee is authorized.
     */
    public function authorize(): bool
    {
        return parent::authorize();
    }

}
