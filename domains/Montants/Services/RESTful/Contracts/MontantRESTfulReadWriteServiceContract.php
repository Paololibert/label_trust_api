<?php

declare(strict_types=1);

namespace Domains\Montants\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`MontantRESTfulReadWriteServiceContract`***
 *
 * The `MontantRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the Montants module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on Montant resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Montants\Services\RESTful\Contracts`***
 */
interface MontantRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
    
}