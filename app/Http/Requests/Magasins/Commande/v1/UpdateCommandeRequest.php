<?php

declare(strict_types = 1);

namespace App\Http\Requests\Magasins\Commande\v1;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Magasins\Commandes\Commande\DataTransfertObjects\UpdateCommandeDTO;

/**
 * Class **`UpdateCommandeRequest`**
 *
 * Represents a form request for creating a Commande. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Magasins\Commande\v1`**
 */
class UpdateCommandeRequest extends UpdateResourceRequest
{

    public function __construct(){
        parent::__construct(UpdateCommandeDTO::fromRequest(request()), 'commande_id');
    }

    /**
     * Determine if the Commande is authorized to make this request.
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
