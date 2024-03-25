<?php

declare(strict_types=1);

namespace Domains\Partners\Clients\Services\RESTful\Contracts;

use App\Models\Contract;
use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;
use Core\Utils\DataTransfertObjects\DTOInterface;

/**
 * Interface ***`ClientRESTfulReadWriteServiceContract`***
 *
 * The `ClientRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the Client module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on Client resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Partners\Clients\Services\RESTful\Contracts`***
 */
interface ClientRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
    
}