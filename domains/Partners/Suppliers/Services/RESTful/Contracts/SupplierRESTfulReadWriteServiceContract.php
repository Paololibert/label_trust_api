<?php

declare(strict_types=1);

namespace Domains\Partners\Suppliers\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;
use Core\Utils\DataTransfertObjects\DTOInterface;

/**
 * Interface ***`SupplierRESTfulReadWriteServiceContract`***
 *
 * The `SupplierRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the Supplier module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on Supplier resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Partners\Suppliers\Services\RESTful\Contracts`***
 */
interface SupplierRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{

}