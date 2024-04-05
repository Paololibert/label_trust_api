<?php

declare(strict_types = 1);

namespace App\Http\Requests\Magasins\Magasin\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Magasins\Magasin\DataTransfertObjects\UpdateMagasinDTO;

/**
 * Class **`UpdateMagasinRequest`**
 *
 * Represents a form request for creating a Magasin. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Magasins\Magasin\v1`**
 */
class UpdateMagasinRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateMagasinDTO::fromRequest(request()), 'magasin');
    }

    /**
     * Determine if the Magasin is authorized to make this request.
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
