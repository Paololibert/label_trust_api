<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1;

use App\Http\Requests\Contrats\v1\CreateContractRequest;
use App\Http\Requests\Contrats\v1\UpdateContractRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Contrats\Services\RESTful\Contracts\ContractRESTfulQueryServiceContract;
use Domains\Contrats\Services\RESTful\Contracts\ContractRESTfulReadWriteServiceContract;

/**
 * **`ContractController`**
 *
 * Controller for managing Contract resources. This controller extends the RESTfulController
 * and provides CRUD operations for Contract resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class ContractController extends RESTfulResourceController
{
    /**
     * Create a new ContractController instance.
     *
     * @param \Domains\Contracts\Services\RESTful\Contracts\ContractRESTfulQueryServiceContract $ContractRESTfulQueryService
     *        The Contract RESTful Query Service instance.
     */
    public function __construct(ContractRESTfulReadWriteServiceContract $ContractRESTfulReadWriteService, ContractRESTfulQueryServiceContract $ContractRESTfulQueryService)
    {
        parent::__construct($ContractRESTfulReadWriteService, $ContractRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateContractRequest::class);
        $this->setRequestClass('update', UpdateContractRequest::class);
    }
}
