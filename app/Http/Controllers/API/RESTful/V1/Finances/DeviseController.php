<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Finances;

use App\Http\Requests\Finances\v1\Devises\CreateDeviseRequest;
use App\Http\Requests\Finances\v1\Devises\UpdateDeviseRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Finances\Devises\Services\RESTful\Contracts\DeviseRESTfulQueryServiceContract;
use Domains\Finances\Devises\Services\RESTful\Contracts\DeviseRESTfulReadWriteServiceContract;

/**
 * **`DeviseController`**
 *
 * Controller for managing departement resources. This controller extends the RESTfulController
 * and provides CRUD operations for departement resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class DeviseController extends RESTfulResourceController
{
    /**
     * Create a new DeviseController instance.
     *
     * @param \Domains\Devises\Services\RESTful\Contracts\DeviseRESTfulQueryServiceContract $departementRESTfulQueryService
     *        The Devise RESTful Query Service instance.
     */
    public function __construct(DeviseRESTfulReadWriteServiceContract $departementRESTfulReadWriteService, DeviseRESTfulQueryServiceContract $departementRESTfulQueryService)
    {
        parent::__construct($departementRESTfulReadWriteService, $departementRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateDeviseRequest::class);
        $this->setRequestClass('update', UpdateDeviseRequest::class);
    }
}
