<?php

declare(strict_types = 1);

namespace App\Http\Requests\Finances\v1\EcrituresComptable;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Finances\EcrituresComptable\DataTransfertObjects\UpdateEcritureComptableDTO;

/**
 * Class **`UpdateEcritureComptableRequest`**
 *
 * Represents a form request for creating a departement. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Finances\v1\EcrituresComptable`**
 */
class UpdateEcritureComptableRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateEcritureComptableDTO::fromRequest(request()), 'ecriture_comptable');
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
