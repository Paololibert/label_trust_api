<?php

declare(strict_types = 1);

namespace App\Http\Requests\EmployeeContractuels\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Employees\EmployeeContractuels\DataTransfertObjects\UpdateEmployeeContractuelDTO;

/**
 * Class **`UpdateEmployeeRequest`**
 *
 * Represents a form request for creating a Employee. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Employees\v1`**
 */
class UpdateEmployeeContractuelRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateEmployeeContractuelDTO::fromRequest(request()), 'employee');
    }

    /**
     * Determine if the Employee is authorized to make this request.
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
