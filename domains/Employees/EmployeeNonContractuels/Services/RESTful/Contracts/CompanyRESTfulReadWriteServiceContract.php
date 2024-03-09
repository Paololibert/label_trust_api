<?php

declare(strict_types=1);

namespace Domains\Users\Companies\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`CompanyRESTfulReadWriteServiceContract`***
 *
 * The `CompanyRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the Company module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on Company resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Users\Companies\Services\RESTful\Contracts`***
 */
interface CompanyRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{

}