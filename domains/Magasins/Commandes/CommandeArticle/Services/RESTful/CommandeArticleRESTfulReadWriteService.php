<?php

declare(strict_types=1);

namespace Domains\Magasins\Commandes\CommandeArticle\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Magasins\Commandes\CommandeArticle\Services\RESTful\Contracts\CommandeArticleRESTfulReadWriteServiceContract;

/**
 * The ***`CommandeArticleRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "CommandeArticle" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "CommandeArticle" resource.
 * It implements the `CommandeArticleRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Magasins\Commandes\CommandeArticle\Services\RESTful`***
 */
class CommandeArticleRESTfulReadWriteService extends RestJsonReadWriteService implements CommandeArticleRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the CommandeArticleRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}