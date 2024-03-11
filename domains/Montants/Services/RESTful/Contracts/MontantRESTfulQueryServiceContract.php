<?php

declare(strict_types=1);

namespace Domains\Montants\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;

/**
 * Interface ***`MontantRESTfulQueryServiceContract`***
 *
 * The `MontantRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to Montant resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to Montant resources.
 *
 * @package ***`\Domains\Montants\Services\RESTful\Contracts`***
 */
interface MontantRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{

}