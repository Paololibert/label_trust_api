<?php

declare(strict_types=1);

namespace Domains\Articles\Article\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;

/**
 * Interface ***`ArticleRESTfulReadWriteServiceContract`***
 *
 * The `ArticleRESTfulReadWriteServiceContract` interface defines the contract for a RESTful read-write service specific to the Articles module.
 * This interface extends the RestJsonReadWriteServiceContract interface provided by the Core module.
 * It inherits the methods for both reading and writing resources in a RESTful manner.
 *
 * Implementing classes should provide the necessary functionality to perform `read` and `write` operations on Article resources via RESTful API endpoints.
 *
 * @package ***`\Domains\Articles\Article\Services\RESTful\Contracts`***
 */
interface ArticleRESTfulReadWriteServiceContract extends RestJsonReadWriteServiceContract
{
    
}