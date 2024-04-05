<?php

declare(strict_types=1);

namespace Domains\Magasins\StorageSpace\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;

/**
 * Interface ***`StorageSpaceRESTfulQueryServiceContract`***
 *
 * The `StorageSpaceRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to StorageSpace resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to StorageSpace resources.
 *
 * @package ***`\Domains\Magasins\StorageSpace\Services\RESTful\Contracts`***
 */
interface StorageSpaceRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{

}