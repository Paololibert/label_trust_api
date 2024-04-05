<?php

declare(strict_types=1);

namespace Domains\Articles\Article\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Articles\Article\Services\RESTful\Contracts\ArticleRESTfulReadWriteServiceContract;

/**
 * The ***`ArticleRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "Article" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "Article" resource.
 * It implements the `ArticleRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Articles\Article\Services\RESTful`***
 */
class ArticleRESTfulReadWriteService extends RestJsonReadWriteService implements ArticleRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the ArticleRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}