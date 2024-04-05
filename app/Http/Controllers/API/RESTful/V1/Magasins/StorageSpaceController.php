<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\RESTful\V1\Magasins;

use App\Http\Requests\Magasins\StorageSpace\v1\CreateStorageSpaceRequest;
use App\Http\Requests\Magasins\StorageSpace\v1\UpdateStorageSpaceRequest;
use Core\Utils\Controllers\RESTful\RESTfulResourceController;
use Domains\Magasins\StorageSpace\Services\RESTful\Contracts\StorageSpaceRESTfulQueryServiceContract;
use Domains\Magasins\StorageSpace\Services\RESTful\Contracts\StorageSpaceRESTfulReadWriteServiceContract;

/**
 * **`MagasinController`**
 *
 * Controller for managing unite_mesure resources. This controller extends the RESTfulController
 * and provides CRUD operations for unite_mesure resources.
 *
 * @package **`\App\Http\Controllers\APIs\RESTful\V1`**
 */
class StorageSpaceController extends RESTfulResourceController
{
    /**
     * Create a new StorageSpaceController instance.
     *
     * @param \Domains\Magasins\StorageSpace\Services\RESTful\Contracts\StorageSpaceRESTfulQueryServiceContract $storage_spaceRESTfulQueryService
     *        The StorageSpace RESTful Query Service instance.
     */
    public function __construct(StorageSpaceRESTfulReadWriteServiceContract $storage_spaceRESTfulReadWriteService, StorageSpaceRESTfulQueryServiceContract $storage_spaceRESTfulQueryService)
    {
        parent::__construct($storage_spaceRESTfulReadWriteService, $storage_spaceRESTfulQueryService);

        // Set specific request classes for store and update methods
        $this->setRequestClass('store', CreateStorageSpaceRequest::class);
        $this->setRequestClass('update', UpdateStorageSpaceRequest::class);
    }
}
