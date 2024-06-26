<?php

declare(strict_types=1);

namespace Domains\Articles\CategorieArticle\Services\RESTful\Contracts;

use Core\Logic\Services\RestJson\Contracts\RestJsonQueryServiceContract;

/**
 * Interface ***`CategorieArticleRESTfulQueryServiceContract`***
 *
 * The `CategorieArticleRESTfulQueryServiceContract` interface is a contract that defines the methods
 * for a RESTful query service specific to CategorieArticle resources.
 *
 * This interface extends the RestJsonQueryServiceContract interface, which provides
 * a set of common methods for performing RESTful queries on JSON-based resources.
 *
 * Implementing classes should provide the necessary implementation for each method
 * defined in this interface, which includes `querying`, `filtering`, `sorting`, `pagination`,
 * and other operations specific to CategorieArticle resources.
 *
 * @package ***`\Domains\Articles\CategorieArticle\Services\RESTful\Contracts`***
 */
interface CategorieArticleRESTfulQueryServiceContract extends RestJsonQueryServiceContract
{

}