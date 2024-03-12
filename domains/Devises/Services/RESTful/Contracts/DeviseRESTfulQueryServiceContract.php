<?php

declare(strict_types=1);

namespace Domains\Devises\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;

/**
 * Interface ***`DeviseRESTfulQueryServiceContract`***
 *
 * The `DeviseRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to Devise resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to Devise resources.
 *
 * @package ***`\Domains\Devises\Services\RESTful\Contracts`***
 */
interface DeviseRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{

}