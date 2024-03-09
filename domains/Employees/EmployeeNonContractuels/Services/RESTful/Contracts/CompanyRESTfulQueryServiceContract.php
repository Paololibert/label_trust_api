<?php

declare(strict_types=1);

namespace Domains\Users\Companies\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;

/**
 * Interface ***`CompanyRESTfulQueryServiceContract`***
 *
 * The `CompanyRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to Company resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to Company resources.
 *
 * @package ***`\Domains\Users\Companies\Services\RESTful\Contracts`***
 */
interface CompanyRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{

}