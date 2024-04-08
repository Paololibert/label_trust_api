<?php

declare(strict_types=1);

namespace Domains\Magasins\ArticleIqp\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Magasins\ArticleIqp\Services\RESTful\Contracts\ArticleIqpRESTfulReadWriteServiceContract;

/**
 * The ***`ArticleIqpRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "ArticleIqp" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "ArticleIqp" resource.
 * It implements the `ArticleIqpRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Magasins\ArticleIqp\Services\RESTful`***
 */
class ArticleIqpRESTfulReadWriteService extends RestJsonReadWriteService implements ArticleIqpRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the ArticleIqpRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}