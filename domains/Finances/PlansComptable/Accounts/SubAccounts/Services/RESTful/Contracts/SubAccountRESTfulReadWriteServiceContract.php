<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`SubAccountRESTfulReadWriteServiceContract`***
 *
 * The `SubAccountRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the SubAccounts module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on SubAccount resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful\Contracts`***
 */
interface SubAccountRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
    
}