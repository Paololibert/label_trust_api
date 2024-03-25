<?php

declare(strict_types=1);

namespace Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful\Contracts\SubAccountRESTfulReadWriteServiceContract;

/**
 * The ***`SubAccountRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "SubAccount" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "SubAccount" resource.
 * It implements the `SubAccountRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Finances\PlansComptable\Accounts\SubAccounts\Services\RESTful`***
 */
class SubAccountRESTfulReadWriteService extends RestJsonReadWriteService implements SubAccountRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the SubAccountRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}