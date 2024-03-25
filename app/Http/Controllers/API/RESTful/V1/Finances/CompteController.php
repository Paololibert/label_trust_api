<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Finances;

use App\Http\Requests\Finances\v1\Comptes\CreateCompteRequest;
use App\Http\Requests\Finances\v1\Comptes\UpdateCompteRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Finances\Comptes\Services\RESTful\Contracts\CompteRESTfulQueryServiceContract;
use Domains\Finances\Comptes\Services\RESTful\Contracts\CompteRESTfulReadWriteServiceContract;

/**
 * **`CompteController`**
 *
 * Controller for managing classe resources. This controller extends the RESTfulController
 * and provides CRUD operations for classe resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class CompteController extends RESTfulResourceController
{
    /**
     * Create a new CompteController instance.
     *
     * @param \Domains\Comptes\Services\RESTful\Contracts\CompteRESTfulQueryServiceContract $compteDeCompteRESTfulQueryService
     *        The Compte RESTful Query Service instance.
     */
    public function __construct(CompteRESTfulReadWriteServiceContract $compteDeCompteRESTfulReadWriteService, CompteRESTfulQueryServiceContract $compteDeCompteRESTfulQueryService)
    {
        parent::__construct($compteDeCompteRESTfulReadWriteService, $compteDeCompteRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateCompteRequest::class);
        $this->setRequestClass('update', UpdateCompteRequest::class);
    }
}
