<?php

declare(strict_types=1);

namespace Domains\Magasins\Commandes\Commande\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Magasins\Commandes\Commande\Services\RESTful\Contracts\CommandeRESTfulReadWriteServiceContract;

/**
 * The ***`CommandeRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Commande" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Commande" resource.
 * It implements the `CommandeRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Magasins\Commandes\Commande\Services\RESTful`***
 */
class CommandeRESTfulReadWriteService extends RestJsonReadWriteService implements CommandeRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the CommandeRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}