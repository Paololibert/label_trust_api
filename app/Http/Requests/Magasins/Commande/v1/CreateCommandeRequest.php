<?php

declare(strict_types = 1);

namespace App\Http\Requests\Magasins\Commande\v1;

use Core\Utils\Requests\CreateResourceRequest;
use Domains\Magasins\Commandes\Commande\DataTransfertObjects\CreateCommandeDTO;

/**
 * Class **`CreateCommandeRequest`**
 *
 * Represents a form request for creating a Commande. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\Magasins\Commande\v1`**
 */
class CreateCommandeRequest extends CreateResourceRequest
{

    public function __construct(){
        parent::__construct(CreateCommandeDTO::fromRequest(request()));
    }

    /**
     * Determine if the Commande is authorized to make this request.
     */
    public function isAuthorize(): bool
    {
        return true;
    }

    /**
     * Authorize the Commande to perform the resource creation operation.
     *
     * This method is called during the authorization phase of the request lifecycle.
     * It sets the Data Transfer Object (DTO) associated with this request and then checks the concrete class's authorization.
     *
     * @return bool Whether the Commande is authorized.
     */
    public function authorize(): bool
    {
        return parent::authorize();
    }

}
