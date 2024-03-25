<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Finances;

use App\Http\Requests\Finances\v1\CategoriesDeCompte\CreateCategorieDeCompteRequest;
use App\Http\Requests\Finances\v1\CategoriesDeCompte\UpdateCategorieDeCompteRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Finances\CategoriesDeCompte\Services\RESTful\Contracts\CategorieDeCompteRESTfulQueryServiceContract;
use Domains\Finances\CategoriesDeCompte\Services\RESTful\Contracts\CategorieDeCompteRESTfulReadWriteServiceContract;

/**
 * **`CategorieDeCompteController`**
 *
 * Controller for managing categorie resources. This controller extends the RESTfulController
 * and provides CRUD operations for categorie resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class CategorieDeCompteController extends RESTfulResourceController
{
    /**
     * Create a new CategorieDeCompteController instance.
     *
     * @param \Domains\CategorieDeComptes\Services\RESTful\Contracts\CategorieDeCompteRESTfulQueryServiceContract $categorieDeCompteRESTfulQueryService
     *        The CategorieDeCompte RESTful Query Service instance.
     */
    public function __construct(CategorieDeCompteRESTfulReadWriteServiceContract $categorieDeCompteRESTfulReadWriteService, CategorieDeCompteRESTfulQueryServiceContract $categorieDeCompteRESTfulQueryService)
    {
        parent::__construct($categorieDeCompteRESTfulReadWriteService, $categorieDeCompteRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateCategorieDeCompteRequest::class);
        $this->setRequestClass('update', UpdateCategorieDeCompteRequest::class);
    }
}
