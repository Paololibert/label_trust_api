<?php

declare(strict_types=1);

namespace Domains\Finances\EcrituresAnalytique\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`EcritureAnalytiqueRESTfulReadWriteServiceContract`***
 *
 * The `EcritureAnalytiqueRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the EcrituresAnalytique module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on EcritureAnalytique resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Finances\EcrituresAnalytique\Services\RESTful\Contracts`***
 */
interface EcritureAnalytiqueRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
    
}