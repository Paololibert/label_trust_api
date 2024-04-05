<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1;

use App\Http\Requests\Partners\v1\CreatePartnerRequest;
use App\Http\Requests\Partners\v1\UpdatePartnerRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Partners\Services\RESTful\Contracts\PartnerRESTfulQueryServiceContract;
use Domains\Partners\Services\RESTful\Contracts\PartnerRESTfulReadWriteServiceContract;

/**
 * **`PartnerController`**
 *
 * Controller for managing Partner resources. This controller extends the RESTfulController
 * and provides CRUD operations for Partner resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class PartnerController extends RESTfulResourceController
{
    /**
     * Create a new PartnerController instance.
     *
     * @param \Domains\Partners\Services\RESTful\Contracts\PartnerRESTfulQueryServiceContract $partnerRESTfulQueryService
     *        The Partner RESTful Query Service instance.
     */
    public function __construct(PartnerRESTfulReadWriteServiceContract $PartnerRESTfulReadWriteService, PartnerRESTfulQueryServiceContract $partnerRESTfulQueryService)
    {
        parent::__construct($PartnerRESTfulReadWriteService, $partnerRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreatePartnerRequest::class);
        $this->setRequestClass('update', UpdatePartnerRequest::class);
        
    }

}
