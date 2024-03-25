<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Finances;

use App\Http\Requests\Finances\v1\ClassesDeCompte\CreateClasseDeCompteRequest;
use App\Http\Requests\Finances\v1\ClassesDeCompte\UpdateClasseDeCompteRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Finances\ClassesDeCompte\Services\RESTful\Contracts\ClasseDeCompteRESTfulQueryServiceContract;
use Domains\Finances\ClassesDeCompte\Services\RESTful\Contracts\ClasseDeCompteRESTfulReadWriteServiceContract;

/**
 * **`ClasseDeCompteController`**
 *
 * Controller for managing classe resources. This controller extends the RESTfulController
 * and provides CRUD operations for classe resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class ClasseDeCompteController extends RESTfulResourceController
{
    /**
     * Create a new ClasseDeCompteController instance.
     *
     * @param \Domains\ClasseDeComptes\Services\RESTful\Contracts\ClasseDeCompteRESTfulQueryServiceContract $classeDeCompteRESTfulQueryService
     *        The ClasseDeCompte RESTful Query Service instance.
     */
    public function __construct(ClasseDeCompteRESTfulReadWriteServiceContract $classeDeCompteRESTfulReadWriteService, ClasseDeCompteRESTfulQueryServiceContract $classeDeCompteRESTfulQueryService)
    {
        parent::__construct($classeDeCompteRESTfulReadWriteService, $classeDeCompteRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateClasseDeCompteRequest::class);
        $this->setRequestClass('update', UpdateClasseDeCompteRequest::class);
    }
}
