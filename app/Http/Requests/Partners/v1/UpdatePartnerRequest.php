<?php

declare(strict_types = 1);

namespace App\Http\Requests\Partners\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Partners\DataTransfertObjects\UpdatePartnerDTO;

/**
 * Class **`UpdatePartnerRequest`**
 *
 * Represents a form request for creating a Partner. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Partners\v1`**
 */
class UpdatePartnerRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdatePartnerDTO::fromRequest(request()), 'partner');
    }

    /**
     * Determine if the Partner is authorized to make this request.
     */
    public function isAuthorize(): bool
    {
        return true;
    }
    
    public function authorize(): bool
    {

        //dd($this->dto);
        return parent::authorize();
    }

}
