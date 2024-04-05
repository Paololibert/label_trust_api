<?php

declare(strict_types=1);

namespace Domains\Articles\CategorieArticle\Services\RESTful;

use Core\Logic\Services\Contracts\ReadWriteServiceContract;
use Core\Logic\Services\RestJson\RestJsonReadWriteService;
use Domains\Articles\CategorieArticle\Services\RESTful\Contracts\CategorieArticleRESTfulReadWriteServiceContract;

/**
 * The ***`CategorieArticleRESTfulReadWriteService`*** class provides RESTful CRUD operations for the "CategorieArticle" resource.
 *
 * This service class extends the `RestJsonReadWriteService` class to handle the read and write operations for the "CategorieArticle" resource.
 * It implements the `CategorieArticleRESTfulReadWriteServiceContract` interface that defines the contract for this service.
 * The class leverages the `JsonResponseTrait` to create consistent JSON responses with `success`, `error`, and `validation` error structures.
 *
 * @package ***`\Domains\Articles\Article\Services\RESTful`***
 */
class CategorieArticleRESTfulReadWriteService extends RestJsonReadWriteService implements CategorieArticleRESTfulReadWriteServiceContract
{
    /**
     * Constructor for the CategorieArticleRESTfulReadWriteService class.
     *
     * @param ReadWriteServiceContract $readWriteService The query service instance to be used.
     */
    public function __construct(ReadWriteServiceContract $readWriteService)
    {
        parent::__construct($readWriteService);
    }

}