<?php

declare(strict_types = 1);

namespace App\Http\Requests\Finances\v1\CategoriesDeCompte;

use Core\Utils\Requests\UpdateResourceRequest;
use Domains\Finances\CategoriesDeCompte\DataTransfertObjects\UpdateCategorieDeCompteDTO;

/**
 * Class **`UpdateCategorieDeCompteRequest`**
 *
 * Represents a form request for creating a categorie. This class extends the base `FormRequest` class provided by Laravel.
 * It handles the validation and authorization of the request data.
 *
 * @package **`\App\Http\Requests\CategoriesDeCompte\v1`**
 */
class UpdateCategorieDeCompteRequest extends UpdateResourceRequest
{
    public function __construct(){
        parent::__construct(UpdateCategorieDeCompteDTO::fromRequest(request()), 'categorie_de_compte');
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
