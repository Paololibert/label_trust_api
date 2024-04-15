<?php

declare(strict_types = 1);

namespace App\Http\Requests\Finances\v1\Immobilisations;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Finances\Immobilisations\DataTransfertObjects\UpdateImmobilisationDTO;

/**
 * Class **`UpdateImmobilisationRequest`**
 *
 * Represents a form request for creating a departement. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Finances\v1\Immobilisations`**
 */
class UpdateImmobilisationRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateImmobilisationDTO::fromRequest(request()), 'immobilisation');
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
