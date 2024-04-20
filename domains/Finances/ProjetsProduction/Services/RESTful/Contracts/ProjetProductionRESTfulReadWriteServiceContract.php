<?php

declare(strict_types=1);

namespace Domains\Finances\ProjetsProduction\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`ProjetProductionRESTfulReadWriteServiceContract`***
 *
 * The `ProjetProductionRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the ProjetsProduction module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on ProjetProduction resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Finances\ProjetsProduction\Services\RESTful\Contracts`***
 */
interface ProjetProductionRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
    
}