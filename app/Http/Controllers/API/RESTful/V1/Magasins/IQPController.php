<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Magasins;

use App\Http\Requests\Magasins\IQP\v1\CreateIQPRequest;
use App\Http\Requests\Magasins\IQP\v1\UpdateIQPRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Magasins\IQP\Services\RESTful\Contracts\IQPRESTfulQueryServiceContract;
use Domains\Magasins\IQP\Services\RESTful\Contracts\IQPRESTfulReadWriteServiceContract;

/**
 * **`IQPController`**
 *
 * Controller for managing unite_mesure resources. This controller extends the RESTfulController
 * and provides CRUD operations for unite_mesure resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class IQPController extends RESTfulResourceController
{
    /**
     * Create a new IQPController instance.
     *
     * @param \Domains\Magasins\IQP\Services\RESTful\Contracts\IQPRESTfulQueryServiceContract $iqpRESTfulQueryService
     *        The IQP RESTful Query Service instance.
     */
    public function __construct(IQPRESTfulReadWriteServiceContract $iqpRESTfulReadWriteService, IQPRESTfulQueryServiceContract $iqpRESTfulQueryService)
    {
        parent::__construct($iqpRESTfulReadWriteService, $iqpRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateIQPRequest::class);
        $this->setRequestClass('update', UpdateIQPRequest::class);
    }
}
