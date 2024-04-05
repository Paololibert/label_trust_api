<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Magasins;

use App\Http\Requests\Magasins\Magasin\v1\CreateMagasinRequest;
use App\Http\Requests\Magasins\Magasin\v1\UpdateMagasinRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Magasins\Magasin\Services\RESTful\Contracts\MagasinRESTfulQueryServiceContract;
use Domains\Magasins\Magasin\Services\RESTful\Contracts\MagasinRESTfulReadWriteServiceContract;

/**
 * **`MagasinController`**
 *
 * Controller for managing unite_mesure resources. This controller extends the RESTfulController
 * and provides CRUD operations for unite_mesure resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class MagasinController extends RESTfulResourceController
{
    /**
     * Create a new MagasinController instance.
     *
     * @param \Domains\Magasins\Magasin\Services\RESTful\Contracts\MagasinRESTfulQueryServiceContract $magasinRESTfulQueryService
     *        The Magasin RESTful Query Service instance.
     */
    public function __construct(MagasinRESTfulReadWriteServiceContract $magasinRESTfulReadWriteService, MagasinRESTfulQueryServiceContract $magasinRESTfulQueryService)
    {
        parent::__construct($magasinRESTfulReadWriteService, $magasinRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateMagasinRequest::class);
        $this->setRequestClass('update', UpdateMagasinRequest::class);
    }
}
