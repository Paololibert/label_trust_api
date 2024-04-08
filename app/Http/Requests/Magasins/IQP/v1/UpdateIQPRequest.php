<?php

declare(strict_types = 1);

namespace App\Http\Requests\Magasins\IQP\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Magasins\IQP\DataTransfertObjects\UpdateIQPDTO;

/**
 * Class **`UpdateIQPRequest`**
 *
 * Represents a form request for creating a IQP. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Magasins\IQP\v1`**
 */
class UpdateIQPRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateIQPDTO::fromRequest(request()), 'iqp');
    }

    /**
     * Determine if the IQP is authorized to make this request.
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
